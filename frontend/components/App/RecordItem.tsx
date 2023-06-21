import { deleteRecord, finishRecord } from '@/lib/api/record'
import { formatDate } from '@/lib/helper'
import { IFile, IRecord } from '@/types/types'
import { Button, Card, Col, Image, Row } from 'react-bootstrap'

type Props = {
  reload: () => void
  record: IRecord
  token: string
}

const RecordItem = ({ reload, record, token }: Props) => {
  const processDelete = () => {
    deleteRecord(record.id, token).finally(reload)
  }

  const finish = () => {
    finishRecord(record.id, token).finally(reload)
  }

  const renderFile = (file: IFile, key: number) => {
    const downloadLink = `${process.env.API_HOST}${file.link}`
    const link = ['jpg', 'jpeg'].includes(file.extension) ? downloadLink : '/file.svg'

    return (
      <Col style={{display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center'}} md={2} key={key}>
        <Image alt={file.name} src={link} style={{maxWidth: '90%', maxHeight: 200, padding: 20}} />
        <a href={downloadLink} target="_blank" style={{fontSize: 12}}>{file.name}</a>
      </Col>
    )
  }

  return (
    <Card className="mb-2" border={record.done ? 'warning' : 'primary'}>
      <Card.Body>
        <Card.Subtitle style={{ fontSize: 11 }} className="mb-1 text-muted">
          <div style={{ display: 'flex', justifyContent: 'space-between' }}>
            <span>Дата создания: {formatDate(record.createdAt)}</span>
            {record.updatedAt !== null && <span>Дата обновления: {formatDate(record.updatedAt)}</span>}
          </div>
        </Card.Subtitle>
        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
          <Card.Text>{record.text}</Card.Text>
          <div>
            {!record.done && (
              <Button size="sm" variant="success" style={{ marginRight: 10 }} onClick={finish}>
                Завершить
              </Button>
            )}
            <Button size="sm" variant="danger" onClick={processDelete}>
              Удалить
            </Button>
          </div>
        </div>
      </Card.Body>
      <Card.Footer className="text-muted">
        <Row>{record.files.map((file, key) => renderFile(file, key))}</Row>
      </Card.Footer>
    </Card>
  )
}

export default RecordItem
