'use client'

import UserList from '@/components/Admin/UserList'
import AppMenu from '@/components/Layout/AppMenu'
import { getUsers } from '@/lib/api/admin'
import { IUser } from '@/types/types'
import { useEffect, useState } from 'react'
import { Col, Container, Row, Spinner } from 'react-bootstrap'

type Props = {
  user: IUser
  token: string
}

const Admin = ({ params }: { params: Props }) => {
  const [users, setUsers] = useState<IUser[] | null>(null)

  const reload = () => {
    setUsers(null)
    getUsers(params.token)
      .then((res) => {
        if (res.status !== 200) {
          setUsers([])
        } else {
          res.json().then((data) => setUsers(data))
        }
      })
      .catch(() => setUsers([]))
      .finally(() => setUsers([]))
  }

  useEffect(reload, [params.token])

  return (
    <>
      <AppMenu user={params.user} />
      <Container className="mt-5">
        <Row className="mt-3 d-flex justify-content-center">
          {users === null && <Spinner animation="border" role="status" />}
          {users !== null && (
            <Col md={12}>
              <UserList reload={reload} users={users} token={params.token} />
            </Col>
          )}
        </Row>
      </Container>
    </>
  )
}

export default Admin
