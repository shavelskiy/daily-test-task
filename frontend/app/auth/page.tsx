'use client'

import AuthForm from '@/components/Auth/AuthForm'
import Menu from '@/components/Layout/Menu'
import { Col, Container, Row } from 'react-bootstrap'

const Auth = async () => {
  return (
    <>
      <Menu />
      <Container className="mt-3">
        <Row>
          <Col md={{ span: 4, offset: 3 }}>
            <h4 className="text-center">Авторизация</h4>
            <AuthForm />
          </Col>
        </Row>
      </Container>
    </>
  )
}

export default Auth
