'use client'

import AppMenu from '@/components/Layout/AppMenu'
import { IUser } from '@/types/types'
import { Container, Row } from 'react-bootstrap'

type Props = {
  user: IUser,
}

const App = ({ params }: { params: Props }) => {
  return (
    <>
      <AppMenu user={params.user} />
      <Container className="mt-3">
        <Row>
          <div>application</div>
        </Row>
      </Container>
    </>
  )
}

export default App
