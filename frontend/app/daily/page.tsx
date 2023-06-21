'use client'

import Picker from '@/components/App/Picker'
import RecordForm from '@/components/App/RecordForm'
import RecordList from '@/components/App/RecordList'
import AppMenu from '@/components/Layout/AppMenu'
import { getRecords } from '@/lib/api/record'
import { IRecord, IUser } from '@/types/types'
import { useEffect, useState } from 'react'
import { Col, Container, Row, Spinner } from 'react-bootstrap'

type Props = {
  user: IUser
  token: string
}

const App = ({ params }: { params: Props }) => {
  const [date, setDate] = useState<Date>(new Date())
  const [records, setRecords] = useState<IRecord[] | null>(null)

  const reload = () => {
    setRecords(null)
    getRecords(date, params.token)
      .then((res) => {
        if (res.status !== 200) {
          setRecords([])
        } else {
          res.json().then((data) => setRecords(data))
        }
      })
      .catch(() => setRecords([]))
      .finally(() => setRecords([]))
  }

  useEffect(reload, [date])

  return (
    <>
      <AppMenu user={params.user} />
      <Container className="mt-5">
        <Picker date={date} setDate={setDate} />
        <Row>
          <Col md={12}>
            <RecordForm date={date} token={params.token} reload={reload} />
          </Col>
        </Row>
        <Row className="mt-3 d-flex justify-content-center">
          {records === null && <Spinner animation="border" role="status" />}
          {records !== null && (
            <Col md={12}>
              <RecordList reload={reload} records={records} token={params.token} />
            </Col>
          )}
        </Row>
      </Container>
    </>
  )
}

export default App
