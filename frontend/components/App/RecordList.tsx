import { IRecord } from '@/types/types'
import { Alert } from 'react-bootstrap'
import RecordItem from './RecordItem'

type Props = {
  reload: () => void
  records: IRecord[]
  token: string
}

const RecordList = ({ reload, records, token }: Props) => {
  if (records.length < 1) {
    return <Alert variant="warning">Записи отсутствуют</Alert>
  }

  return records.map((record, key) => <RecordItem key={key} reload={reload} record={record} token={token} />)
}

export default RecordList
