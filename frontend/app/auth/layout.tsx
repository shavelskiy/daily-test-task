import { getUser } from '@/lib/api/security'
import { redirect } from 'next/navigation'
import { cookies } from 'next/headers'

export const metadata = {
  title: 'Авторизация',
}

const AuthLayout = async ({ children }: { children: React.ReactNode }) => {
  if ((await getUser(cookies())) !== null) {
    redirect('/daily')
  }

  return <>{children}</>
}

export default AuthLayout
