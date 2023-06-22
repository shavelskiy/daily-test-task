import cookie from 'js-cookie'

export const login = async (token: string) => {
  await cookie.set(`user_token`, token, { expires: 365 })
}

export const getToken = (): string => {
  const token = cookie.get('user_token')
  return token ? token : ''
}

export const logout = async () => {
  await cookie.remove(`user_token`)
}
