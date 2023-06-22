import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button'
import Alert from 'react-bootstrap/Alert'
import { useState } from 'react'
import { auth } from '@/lib/api/security'
import { login } from '@/lib/auth'
import { useRouter } from 'next/navigation'

const AuthForm = () => {
  const router = useRouter()

  const [loading, setLoading] = useState<boolean>(false)
  const [result, setResult] = useState<boolean | null>(null)
  const [block, setBlock] = useState<boolean>(false)

  const [email, setEmail] = useState<string>('')
  const [password, setPasword] = useState<string>('')

  const submit = () => {
    setLoading(true)
    setResult(null)
    setBlock(false)

    auth(email, password)
      .then((result) => {
        if (result.status === 400) {
          setResult(false)
        } else if (result.status === 403) {
          setBlock(true)
        } else {
          result.json().then((data) => {
            login(data.token).then(
              () => {
                setResult(true)
                setTimeout(() => router.push(`/daily`), 500)
              }
            )
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
      {result === true && <Alert variant="success">Вы успешно авторизовались</Alert>}
      {result === false && <Alert variant="danger">Неверный логин или пароль</Alert>}
      {block && <Alert variant="danger">Ваш пользователь заблокирован</Alert>}
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
        Войти
      </Button>
    </Form>
  )
}

export default AuthForm
