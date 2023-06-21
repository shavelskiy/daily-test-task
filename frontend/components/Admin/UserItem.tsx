import { blockUser, deleteUser, unblockUser } from '@/lib/api/admin'
import { formatDate } from '@/lib/helper'
import { IUser } from '@/types/types'
import { Button, Card } from 'react-bootstrap'

type Props = {
  user: IUser
  token: string
  reload: () => void
}

const UserItem = ({ user, token, reload }: Props) => {
  const processBlock = () => blockUser(user.id, token).finally(reload)

  const processUnblock = () => unblockUser(user.id, token).finally(reload)

  const processDelete = () => deleteUser(user.id, token).finally(reload)

  return (
    <Card className="mb-2" border={user.active ? 'primary' : 'warning'}>
      <Card.Body>
        <Card.Subtitle style={{ fontSize: 11 }} className="mb-1 text-muted">
          <div style={{ display: 'flex', justifyContent: 'space-between' }}>
            <span>Дата Регистрации: {formatDate(user.createdAt)}</span>
          </div>
        </Card.Subtitle>
        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
          <Card.Text>{user.email}</Card.Text>
          <div>
            <Button
              size="sm"
              variant={user.active ? 'warning' : 'success'}
              style={{ marginRight: 10 }}
              onClick={user.active ? processBlock : processUnblock}
            >
              {user.active ? 'Заблокировать' : 'Разблокировать'}
            </Button>
            <Button size="sm" variant="danger" onClick={processDelete}>
              Удалить
            </Button>
          </div>
        </div>
      </Card.Body>
    </Card>
  )
}

export default UserItem
