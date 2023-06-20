import { IUser } from '@/types/types'
import { ReadonlyRequestCookies } from 'next/dist/server/web/spec-extension/adapters/request-cookies'

export const auth = (email: string, password: string): Promise<Response> => {
  return fetch('http://localhost:8181/v1/security/auth', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      email: email,
      password: password,
    }),
  })
}

export const register = (email: string, password: string): Promise<Response> => {
  return fetch('http://localhost:8181/v1/security/register', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      email: email,
      password: password,
    }),
  })
}

export const isAuth = async (cookieStore: ReadonlyRequestCookies): Promise<boolean> => {
  return getUser(cookieStore) !== null
}

export const getUser = async (cookieStore: ReadonlyRequestCookies): Promise<IUser | null> => {
  const cookie = cookieStore.get('user_token')

  if (!cookie) {
    return null
  }

  const token = cookie.value

  const res = await fetch('http://localhost:8181/v1/security/user', {
    headers: {
      Authorization: 'Bearer ' + token,
    },
  })

  if (res.status !== 200) {
    return null
  }

  const data = await res.json()

  return {
    id: data.id,
    email: data.email,
    admin: data.admin,
  }
}
