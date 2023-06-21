export const getUsers = (token: string): Promise<Response> => {
  return fetch(`${process.env.API_HOST}/v1/admin/user`, {
    headers: {
      Authorization: 'Bearer ' + token,
    },
  })
}

export const blockUser = (id: string, token: string): Promise<Response> => {
  return fetch(`${process.env.API_HOST}/v1/admin/user/access/${id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + token,
    },
    body: JSON.stringify({
      active: false,
    }),
  })
}

export const unblockUser = (id: string, token: string): Promise<Response> => {
  return fetch(`${process.env.API_HOST}/v1/admin/user/access/${id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + token,
    },
    body: JSON.stringify({
      active: true,
    }),
  })
}

export const deleteUser = (id: string, token: string): Promise<Response> => {
  return fetch(`${process.env.API_HOST}/v1/admin/user/${id}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + token,
    },
  })
}
