export const createRecord = (text: string, date: Date, token: string): Promise<Response> => {
  return fetch('http://localhost:8181/v1/record', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + token,
    },
    body: JSON.stringify({
      text: text,
      date: date,
    }),
  })
}

export const getRecords = (date: Date, token: string): Promise<Response> => {
  return fetch(`http://localhost:8181/v1/record?date=${date.toISOString()}`, {
    headers: {
      Authorization: 'Bearer ' + token,
    },
  })
}

export const finishRecord = (id: string, token: string): Promise<Response> => {
  return fetch(`http://localhost:8181/v1/record/finish/${id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + token,
    }
  })
}

export const deleteRecord = (id: string, token: string): Promise<Response> => {
  return fetch(`http://localhost:8181/v1/record/${id}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + token,
    }
  })
}
