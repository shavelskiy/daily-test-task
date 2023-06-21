export type IUser = {
  id: string
  email: string
  admin: boolean
}

export type IRecord = {
  id: string
  user: IUser
  done: boolean
  text: string
  date: string
  createdAt: string
  updatedAt: ?string
}
