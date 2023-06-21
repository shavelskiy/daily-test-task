import { createRecord } from '@/lib/api/record'
import { useState } from 'react'
import { Button, Modal } from 'react-bootstrap'
import Form from 'react-bootstrap/Form'

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
  const submit = () => {
    if (text.length < 1) {
      return
    }

    setLoading(true)
    createRecord(text, date, token).finally(() => {
      setText('')
      setShow(false)
      setLoading(false)
      reload()
    })
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
