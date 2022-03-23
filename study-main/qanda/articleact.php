<?php

include_once 'act.php';

// 記事取得系
define("QUERY_ARTICLE_LIST", "SELECT ARTICLE_ID,USER_ID,TITLE,MESSAGE,POST_DATE,UPD_DATE,CATE_ID,ARTICLE_IMAGE FROM article_posts %s ORDER BY UPD_DATE DESC LIMIT :limit OFFSET :offset");
define("QUERY_ARTICLE", "SELECT ARTICLE_ID,USER_ID,TITLE,MESSAGE,POST_DATE,UPD_DATE,CATE_ID,ARTICLE_IMAGE FROM article_posts WHERE ARTICLE_ID=:article_id");
define("QUERY_ARTICLE_COUNT", "SELECT COUNT(ARTICLE_ID) AS CNT FROM article_posts %s");
define("QUERY_ARTICLE_LIKEME_LIST", "SELECT A.ARTICLE_ID,A.USER_ID,A.TITLE,A.MESSAGE,A.POST_DATE,A.UPD_DATE,A.CATE_ID,A.ARTICLE_IMAGE FROM article_posts A, article_likes B WHERE A.ARTICLE_ID = B.ARTICLE_ID AND B.USER_ID=:user_id AND B.LIKE_FLG=1 ORDER BY A.UPD_DATE DESC LIMIT :limit");

// 記事更新系
define("INSERT_ARTICLE", "INSERT INTO article_posts (USER_ID,TITLE,MESSAGE,POST_DATE,UPD_DATE,CATE_ID) VALUES (:user_id, :title, :message, now(), now(), :cate_id)");
define("UPDATE_ARTICLE", "UPDATE article_posts SET TITLE=:title,MESSAGE=:message,CATE_ID=:cate_id,UPD_DATE=now() WHERE ARTICLE_ID=:article_id AND USER_ID=:user_id");
define("DELETE_ARTICLE", "DELETE FROM article_posts WHERE ARTICLE_ID=:article_id AND USER_ID=:user_id");

// カテゴリ一覧
define("QUERY_CATEGORY_LIST", "SELECT CATE_ID,CATEGORY_NAME FROM categories");

// いいね取得系
define("QUERY_POSTLIKE", "SELECT A_LIKE_ID,USER_ID,ARTICLE_ID,LIKE_FLG FROM article_likes WHERE ARTICLE_ID=:article_id AND USER_ID=:user_id");
define("QUERY_POSTLIKE_COUNTLIST", "SELECT ARTICLE_ID,COUNT(A_LIKE_ID) AS LIKECNT FROM article_likes WHERE ARTICLE_ID IN (%s) AND LIKE_FLG=1 GROUP BY ARTICLE_ID");

// いいね更新系
define("INSERT_POSTLIKE", "INSERT INTO article_likes (USER_ID, ARTICLE_ID, LIKE_FLG) VALUES (:user_id, :article_id, 1)");
define("UPDATE_POSTLIKE", "UPDATE article_likes SET LIKE_FLG=:like_flg WHERE A_LIKE_ID=:a_like_id");

// 記事/イイね関連クラス
class ArticleAct extends Action
{
    // 記事一覧
    function articlelist($page, $searchtext = '') {
        $retinfo = array();

        {
            $retlist = array();
            $inWhere = '';
            if ($searchtext != '') {
                $inWhere = "WHERE TITLE LIKE '%" . $searchtext ."%'";
            }

            // 記事リスト(指定されたpage 20件)
            $offset = $page * LISTCOUNT;
            $handle = $this->conn->prepare(sprintf(QUERY_ARTICLE_LIST, $inWhere));
            $handle->bindValue(':limit', (int)LISTCOUNT, PDO::PARAM_INT);
            $handle->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $result = $handle->execute();
            if ($result) {
                while ($rec =  $handle->fetch(PDO::FETCH_ASSOC)) {
                    $retlist[] = $rec;
                }
            }
            $retinfo['articlelist'] = $retlist;

            // ユーザ情報
            $retinfo['usermap'] = $this->membermap($retlist, 'USER_ID');

            // イイね数
            $retinfo['postlikemap'] = $this->likecountmap($retlist);
        }

        // 記事全体の数
        {
            $handle = $this->conn->prepare(sprintf(QUERY_ARTICLE_COUNT, $inWhere));
            $result = $handle->execute();
            $cntrec = $result ? $handle->fetch(PDO::FETCH_ASSOC): NULL;
            $cnt = $cntrec == NULL ? 0: $cntrec['CNT'];
            $retinfo['cnt'] = $cnt;
            $maxpage = floor(($cnt - 1)/ LISTCOUNT);
            $retinfo['MAXPAGE'] = $maxpage;
        }

        // カテゴリ
        $retinfo['category'] = $this->categorymap();

        return $retinfo;
    }

    // 記事単独
    function article($article_id) {
        $retinfo = array();

        // 記事
        {
            $handle = $this->conn->prepare(QUERY_ARTICLE);
            $handle->bindValue(':article_id', $article_id);
            $result = $handle->execute();
            $article = $result ? $handle->fetch(PDO::FETCH_ASSOC): NULL;
            $retinfo['article'] = $article;

            // ユーザ情報
            $retinfo['user'] = $this->memberref($article['USER_ID']);
        }

        // イイねした?
        $retinfo['postlike'] = $this->postlike($article_id);

        // イイね数取得
        {
            $handle = $this->conn->query(sprintf(QUERY_POSTLIKE_COUNTLIST, $article_id));
            $postlikecnt = $handle->fetch(PDO::FETCH_ASSOC);
            $retinfo['postlikecnt'] = $postlikecnt == NULL ? 0: $postlikecnt['LIKECNT'];
        }

        // カテゴリ
        $retinfo['category'] = $this->categorymap();

        return $retinfo;
    }

    // 記事投稿
    function postarticle($title, $message, $cate_id) {
        $handle = $this->conn->prepare(INSERT_ARTICLE);
        $handle->bindValue(':user_id', $this->member['USER_ID']);
        $handle->bindValue(':title', $title);
        $handle->bindValue(':message', $message);
        $handle->bindValue(':cate_id', $cate_id);
        $handle->execute();
    }

    // 記事更新
    function updatearticle($articleid, $title, $message, $cate_id) {
        $handle = $this->conn->prepare(UPDATE_ARTICLE);
        $handle->bindValue(':article_id', $articleid);
        $handle->bindValue(':user_id', $this->member['USER_ID']);
        $handle->bindValue(':title', $title);
        $handle->bindValue(':message', $message);
        $handle->bindValue(':cate_id', $cate_id);
        $handle->execute();
    }

    // 記事削除
    function deletearticle($articleid) {
        $handle = $this->conn->prepare(DELETE_ARTICLE);
        $handle->bindValue(':user_id', $this->member['USER_ID']);
        $handle->bindValue(':article_id', $articleid);
        $handle->execute();
    }

    // イイね押下/解除時の処理
    function postlikearticle($articleid) {
        $retcode = 'error';
        try {
            $this->conn->beginTransaction();

            // 登録済み?
            $postlike = $this->postlike($articleid);
            if ($postlike == NULL) {
            // 登録
                $handle = $this->conn->prepare(INSERT_POSTLIKE);
                $handle->bindValue(':user_id', $this->member['USER_ID']);
                $handle->bindValue(':article_id', $articleid);
                $handle->execute();
                $retcode = 'likeset';
            } else {
            // （現在の状態を反転させて）更新

                $likeflg = $postlike['LIKE_FLG'] == 1 ? 0: 1;
                $handle = $this->conn->prepare(UPDATE_POSTLIKE);
                $handle->bindValue(':like_flg', $likeflg);
                $handle->bindValue(':a_like_id', $postlike['A_LIKE_ID']);
                $handle->execute();
                $retcode = $likeflg == 1 ? 'likeset': 'reset';
            }

            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollback();
        }
        return $retcode;
    }

    // カテゴリマップ。戻り値は CATE_ID とカテゴリ名の連想配列。
    function categorymap() {
        $keymap = array();
        $result = $this->conn->query(QUERY_CATEGORY_LIST);
        if ($result) {
            while ($rec =  $result->fetch(PDO::FETCH_ASSOC)) {
                $keymap[$rec['CATE_ID']] = $rec['CATEGORY_NAME'];
            }
        }
        return $keymap;
    }

    // イイね情報取得
    function postlike($article_id) {
        $handle = $this->conn->prepare(QUERY_POSTLIKE);
        $handle->bindValue(':article_id', $article_id);
        $handle->bindValue(':user_id', $this->member['USER_ID']);
        $result = $handle->execute();
        $postlike = $result ? $handle->fetch(PDO::FETCH_ASSOC): NULL;
        return $postlike;
    }

    // イイねした記事の一覧取得
    function postlikeArticleList() {
        $retinfo = array();

        // 記事一覧
        $retlist = array();
        $handle = $this->conn->prepare(QUERY_ARTICLE_LIKEME_LIST);
        $handle->bindValue(':user_id', $this->member['USER_ID']);
        $handle->bindValue(':limit', (int)LISTCOUNT_MYPAGE, PDO::PARAM_INT);
        $result = $handle->execute();
        if ($result) {
            while ($mem = $handle->fetch(PDO::FETCH_ASSOC)) {
                $retlist[] = $mem;
            }
        }
        $retinfo['articlelist'] = $retlist;

        // ユーザ情報
        $retinfo['usermap'] = $this->membermap($retlist, 'USER_ID');

        // イイね数
        $retinfo['postlikemap'] = $this->likecountmap($retlist);

        return $retinfo;
    }

    // イイね数を返す。戻り値は ARTICLE_ID とイイね数の連想配列。
    function likecountmap($articles) {
        $countmap = array();
        if (count($articles) == 0) {
            return $countmap;
        }

        // where句の作成
        $ids = array();
        foreach ($articles as $art) {
            $ids[] = $art['ARTICLE_ID'];
        }
        $inClause = substr(str_repeat(',?', count($ids)), 1);

        // イイね数取得
        $handle = $this->conn->prepare(sprintf(QUERY_POSTLIKE_COUNTLIST, $inClause));
        $result = $handle->execute($ids);
        if ($result) {
            while ($mem = $handle->fetch(PDO::FETCH_ASSOC)) {
                $countmap[$mem['ARTICLE_ID']] = $mem['LIKECNT'];
            }
        }
        return $countmap;
    }
}

?>
