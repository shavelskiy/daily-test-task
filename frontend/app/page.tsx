import { redirect } from 'next/navigation'

const Home = async () => {
  const res = await fetch("http://localhost:8181/v1/security/user");

  if (res.status !== 200) {
    redirect('/auth')
  }

  return <></>;
};

export default Home;
