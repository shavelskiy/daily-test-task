'use client'

import RegisterForm from '@/components/Auth/RegisterForm'
import Menu from '@/components/Layout/Menu'
import { Col, Container, Row } from 'react-bootstrap'

const Register = async () => {
  return (
    <>
      <Menu />
      <Container className="mt-3">
        <Row>
          <Col md={{ span: 4, offset: 3 }}>
            <h4 className="text-center">Регистрация</h4>
            <RegisterForm />
          </Col>
        </Row>
      </Container>
    </>
  )
}

export default Register
