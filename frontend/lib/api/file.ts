import axios from 'axios'

export const uploadFile = (file: File, token: string): Promise<Response> => {
  const formData = new FormData()
  formData.append('file', file)

  return axios.post(`${process.env.API_HOST}/v1/file`, formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
      Authorization: 'Bearer ' + token,
    },
  })
}
