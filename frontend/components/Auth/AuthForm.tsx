
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import Alert from "react-bootstrap/Alert";
import { useState } from "react";
import { auth } from "@/lib/api/security";

const AuthForm = () => {
  const [loading, setLoading] = useState<boolean>(false);
  const [showError, setShowError] = useState<boolean>(false);

  const [email, setEmail] = useState<string>("");
  const [password, setPasword] = useState<string>("");

  const submit = () => {
    setLoading(true);
    setShowError(false);

    auth(email, password)
      .then((result) => {
        if (result.status !== 200) {
          setShowError(true);
        } else {
          result.json().then((data) => {
            console.log(data.token);
          });
        }
      })
      .catch(() => setShowError(true))
      .finally(() => setLoading(false));
  };

  return (
    <Form
      onSubmit={(e) => {
        e.preventDefault();
        submit();
      }}
    >
      {showError && <Alert variant="danger">Неверный логин или пароль</Alert>}
      <Form.Group className="mb-3" controlId="email">
        <Form.Label>Email</Form.Label>
        <Form.Control
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
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
  );
};

export default AuthForm;
