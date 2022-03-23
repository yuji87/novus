import React, { FC } from 'react'
import axios from 'axios'
import Button from "components/Button"
import { Meetings } from 'types/response'

type CreateMeetingProps = {
setMeeting: React.Dispatch<React.SetStateAction<Meetings>>
  isNotification: boolean
  }

  const CreateMeeting: FC<{createMeetingProps: CreateMeetingProps }> = ({ createMeetingProps}) => {
    const { setMeeting, isNotification } = createMeetingProps
    const createMeeting = async() => {
    try {
    const result = await axios.get<Meetings>('https://xxxxxxx.xxxxxxx-api.ap-northeast-1.amazonaws.com/prod')
      // CountDownコンポーネントを再描画させる
      setMeeting(null)
      await setMeeting(result.data)
      if (isNotification) new Notification('新規ミーティングが作成されました。')
      } catch {
      if (isNotification) new Notification('ミーティング作成に失敗しました。')
      }
      }

      return (
      <Button event={createMeeting}>
        会議を開始
      </Button>
      )
      }

      export default CreateMeeting