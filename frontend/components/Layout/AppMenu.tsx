import Container from 'react-bootstrap/Container'
import Nav from 'react-bootstrap/Nav'
import Navbar from 'react-bootstrap/Navbar'
import Link from 'next/link'
import { logout } from '@/lib/auth'
import { useRouter } from 'next/navigation'
import { IUser } from '@/types/types'

const AppMenu = ({ user }: { user: IUser }) => {
  const router = useRouter()

  const logoutAction = () => {
    logout()
    router.replace(`/auth`)
  }

  return (
    <Navbar bg="dark" data-bs-theme="dark" expand="lg">
      <Container>
        <Link href="/daily" className="navbar-brand">
          Daily
        </Link>

        <Navbar.Toggle aria-controls="basic-navbar-nav" />
        <Navbar.Collapse id="basic-navbar-nav">
          {user.admin && (
            <Link href="/admin" className="navbar-text">
              Панель администратора
            </Link>
          )}

          <Nav className="ms-auto">
            <Navbar.Text>({user.email})</Navbar.Text>
            <span className="nav-link" onClick={logoutAction}>
              Выход
            </span>
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  )
}

export default AppMenu
