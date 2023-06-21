import { getToken, getUser } from '@/lib/api/security'
import { redirect } from 'next/navigation'
import { cookies } from 'next/headers'

import "react-datepicker/dist/react-datepicker.css";

export const metadata = {
  title: 'Панель администратора',
}

const AdminLayout = async (props: { children: React.ReactNode, params: object }) => {
  const user = await getUser(cookies())
  if (user === null) {
    redirect('/auth')
  }

  if (!user.admin) {
    redirect('/daily')
  }

  props.params.user = user
  props.params.token = getToken(cookies())
  return <>{props.children}</>
}

export default AdminLayout
