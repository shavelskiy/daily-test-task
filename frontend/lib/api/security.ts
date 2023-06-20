export const auth = (email: string, password: string): Promise<Response> => {
  return fetch('http://localhost:8181/v1/security/auth', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      email: email,
      password: password,
    })
  })
}
