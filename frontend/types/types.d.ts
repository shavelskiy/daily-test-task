export type IUser = {
  id: string
  email: string
  admin: boolean
  active: boolean
  createdAt: string
}

export type IFile = {
  id: string
  name: string
  extension: string
  link: string
}

export type IRecord = {
  id: string
  user: IUser
  files: IFile[]
  done: boolean
  text: string
  date: string
  createdAt: string
  updatedAt: ?string
}
