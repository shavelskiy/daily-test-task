import { getUser } from '@/lib/api/security'
import { redirect } from 'next/navigation'
import { cookies } from 'next/headers'

export const metadata = {
  title: 'Ежедневник',
}

const AppLayout = async (props: { children: React.ReactNode, params: object }) => {
  const user = await getUser(cookies())
  if (user === null) {
    redirect('/auth')
  }

  props.params.user = user
  return <>{props.children}</>
}

export default AppLayout
