import { getToken, getUser } from '@/lib/api/security'
import { redirect } from 'next/navigation'
import { cookies } from 'next/headers'

import "react-datepicker/dist/react-datepicker.css";
import { IUser } from '@/types/types';

export const metadata = {
  title: 'Ежедневник',
}

const AppLayout = async (props: { children: React.ReactNode, params: {user: IUser, token: string} }) => {
  const user = await getUser(cookies())
  if (user === null || !user.active) {
    redirect('/auth')
  }

  props.params.user = user
  props.params.token = getToken(cookies())
  return <>{props.children}</>
}

export default AppLayout
