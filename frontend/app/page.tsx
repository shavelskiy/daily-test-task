import { redirect } from 'next/navigation'
import { cookies } from 'next/headers'
import { getUser } from '@/lib/api/security'

const Home = async () => {
  redirect((await getUser(cookies())) ? '/daily' : '/auth')
}

export default Home
