import { createRecord } from '@/lib/api/record'
import { useState } from 'react'
import { Button, Modal } from 'react-bootstrap'
import Form from 'react-bootstrap/Form'
import RecordFormFiles from './RecordFormFiles'
import { uploadFile } from '@/lib/api/file'

type ModalFormProps = {
  reload: () => void
  token: string
  date: Date
  show: boolean
  setShow: (v: boolean) => void
}

type Props = {
  reload: () => void
  token: string
  date: Date
}

const ModalForm = ({ date, show, setShow, token, reload }: ModalFormProps) => {
  const [loading, setLoading] = useState<boolean>(false)
  const [text, setText] = useState<string>('')
  const [files, setFiles] = useState<File[]>([])

  const isValidFile = (file: File): boolean => {
    return ['application/pdf', 'image/jpeg', 'image/jpg', 'application/msword'].includes(file.type)
  }

  const submit = () => {
    if (text.length < 1) {
      return
    }

    setLoading(true)
    Promise.all(files.filter((file) => isValidFile(file)).map((file) => uploadFile(file, token)))
      .then((data) => {
        const fileIds = data.map((data) => data.data.id)

        createRecord(text, fileIds, date, token).finally(() => {
          setText('')
          setFiles([])
          setShow(false)
          setLoading(false)
          reload()
        })
      })
      .catch(() => setLoading(false))
  }

  return (
    <Modal show={show} onHide={() => setShow(false)} backdrop="static">
      <Modal.Header closeButton>
        <Modal.Title>Добавление записи</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <Form.Group className="mb-3">
          <Form.Control as="textarea" rows={3} value={text} onChange={(e) => setText(e.target.value)} />
        </Form.Group>

        <RecordFormFiles files={files} setFiles={setFiles} isValidFile={isValidFile} />
      </Modal.Body>
      <Modal.Footer>
        <Button variant="secondary" onClick={() => setShow(false)}>
          Закрыть
        </Button>
        <Button variant="primary" onClick={submit} disabled={loading}>
          Добавить
        </Button>
      </Modal.Footer>
    </Modal>
  )
}

const RecordForm = ({ date, token, reload }: Props) => {
  const [showForm, setShowForm] = useState<boolean>(false)

  return (
    <>
      <Button variant="primary" onClick={() => setShowForm(true)}>
        Добавиь запись
      </Button>
      <ModalForm date={date} show={showForm} setShow={setShowForm} token={token} reload={reload} />
    </>
  )
}

export default RecordForm
