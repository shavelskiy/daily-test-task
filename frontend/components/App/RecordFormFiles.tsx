import { CloseButton, Col, Image, Row } from 'react-bootstrap'
import Form from 'react-bootstrap/Form'

type Props = {
  files: File[]
  setFiles: (v: File[]) => void
}

const RecordFormFiles = ({ files, setFiles }: Props) => {
  const isValidFile = (file: File): boolean => {
    return ['application/pdf', 'image/jpeg', 'image/jpg', 'application/msword'].includes(file.type)
  }

  const getFilePath = (file: File): string => {
    if (file.type.startsWith('image/')) {
      return URL.createObjectURL(file)
    }

    return '/file.svg'
  }

  const deleteFile = (key: number): void => {
    setFiles(files.filter((file, fileKey) => key !== fileKey))
  }

  return (
    <Form.Group controlId="formFileMultiple" className="mb-3">
      <Form.Label style={{fontSize: 13}}>
        Загрузите файлы к записи. Для загрузки допустимы только файлы pdf, jpeg, doc. При загрузке остальные файлы будут
        проигнорированы
      </Form.Label>

      {files.length > 0 && (
        <Row className="mb-2">
          {files.map((file, key) => (
            <Col md={3} key={key} className="mb-3" style={{ position: 'relative', overflow: 'hidden' }}>
              <Image
                src={getFilePath(file)}
                thumbnail
                style={{ width: '60%', borderColor: isValidFile(file) ? '#adb5bd' : 'red' }}
              />
              <CloseButton style={{ position: 'absolute', top: 0, right: 10 }} onClick={() => deleteFile(key)} />
              <div style={{ fontSize: 12, color: isValidFile(file) ? '#495057' : 'red' }}>{file.name}</div>
            </Col>
          ))}
        </Row>
      )}

      <Form.Control type="file" multiple onChange={(e) => setFiles([...files, ...Array.from(e.target.files)])} />
    </Form.Group>
  )
}

export default RecordFormFiles
