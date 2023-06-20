import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
import Link from "next/link";

const Menu = () => {
  return (
    <Navbar bg="dark" data-bs-theme="dark" expand="lg">
      <Container>
        <Link href="/" className="navbar-brand">
          Daily
        </Link>

        <Navbar.Toggle aria-controls="basic-navbar-nav" />
        <Navbar.Collapse id="basic-navbar-nav">
          <Nav className="ms-auto">
            <Link href="/register" className="nav-link">
              Регистрация
            </Link>
            <Link href="/" className="nav-link">
              Вход
            </Link>
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
};

export default Menu;
