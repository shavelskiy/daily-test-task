import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button'
import Alert from 'react-bootstrap/Alert'
import { useState } from 'react'
import { register } from '@/lib/api/security'
import { login } from '@/lib/auth'
import { useRouter } from 'next/navigation'

const RegisterForm = () => {
  const router = useRouter()

  const [loading, setLoading] = useState<boolean>(false)
  const [result, setResult] = useState<boolean | null>(null)

  const [email, setEmail] = useState<string>('')
  const [password, setPasword] = useState<string>('')

  const submit = () => {
    setLoading(true)
    setResult(null)

    register(email, password)
      .then((result) => {
        if (result.status !== 200) {
          setResult(false)
        } else {
          result.json().then((data) => {
            login(data.token)
            setResult(true)
            setTimeout(() => router.push(`/daily`), 500)
          })
        }
      })
      .catch(() => setResult(false))
      .finally(() => setLoading(false))
  }

  return (
    <Form
      onSubmit={(e) => {
        e.preventDefault()
        submit()
      }}
    >
      {result === true && <Alert variant="success">Вы успешно зарегистрировались</Alert>}
      {result === false && (
        <Alert variant="danger">При регистрации произошла ошибка или пользователь с таким email уже существует</Alert>
      )}
      <Form.Group className="mb-3" controlId="email">
        <Form.Label>Email</Form.Label>
        <Form.Control type="email" placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)} />
      </Form.Group>

      <Form.Group className="mb-3" controlId="password">
        <Form.Label>Пароль</Form.Label>
        <Form.Control
          type="password"
          placeholder="Пароль"
          value={password}
          onChange={(e) => setPasword(e.target.value)}
        />
      </Form.Group>

      <Button variant="primary" type="submit" disabled={loading}>
        Зарегистрироваться
      </Button>
    </Form>
  )
}

export default RegisterForm
