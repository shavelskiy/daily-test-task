import { getUser } from '@/lib/api/security'
import { redirect } from 'next/navigation'
import { cookies } from 'next/headers'

export const metadata = {
  title: 'Авторизация',
}

const AppLayout = async ({ children }: { children: React.ReactNode }) => {
  if ((await getUser(cookies())) === null) {
    redirect('/auth')
  }

  return <>{children}</>
}

export default AppLayout
