import { getUser } from '@/lib/api/security'
import { redirect } from 'next/navigation'
import { cookies } from 'next/headers'

export const metadata = {
  title: 'Авторизация',
}

const AuthLayout = async ({ children }: { children: React.ReactNode }) => {
  const user = await getUser(cookies())

  if (user !== null && user.active) {
    redirect('/daily')
  }

  return <>{children}</>
}

export default AuthLayout
