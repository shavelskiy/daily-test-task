'use client'

import AppMenu from '@/components/Layout/AppMenu'
import { Container, Row } from 'react-bootstrap'

const App = () => {
  return (
    <>
      <AppMenu />
      <Container className="mt-3">
        <Row>
          <div>application</div>
        </Row>
      </Container>
    </>
  )
}

export default App
