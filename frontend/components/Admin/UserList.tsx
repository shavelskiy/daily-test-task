import { IUser } from '@/types/types'
import UserItem from './UserItem'

type Props = {
  users: IUser[]
  token: string
  reload: () => void
}

const UserList = ({ users, token, reload }: Props) => {
  return users.map((user, key) => <UserItem key={key} user={user} token={token} reload={reload} />)
}

export default UserList
