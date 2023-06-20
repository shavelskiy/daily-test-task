import cookie from 'js-cookie'

export const login = (token: string) => {
  cookie.set(`user_token`, token, { expires: 365 })
}

export const logout = () => {
  cookie.remove(`user_token`)
}
