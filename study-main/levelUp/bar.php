        <?php # 経験値バー 
        ?>
        <div class="progress" style="height:4px;">
          <div id="expbar" class="progress-bar bg-primary" role="progressbar" style="width:<?= $before_pokemon->getPerCompNexExp() ?>%;" aria-valuenow="<?= $before_pokemon->getPerCompNexExp() ?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>