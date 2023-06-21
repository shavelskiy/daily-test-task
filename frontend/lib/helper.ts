const months = [
  `января`,
  `февраля`,
  `марта`,
  `апреля`,
  `мая`,
  `июня`,
  `июля`,
  `августа`,
  `сентября`,
  `октября`,
  `ноября`,
  `декабря`,
]

const formatTime = (data: number): string => {
  if (data > 9) {
    return data.toString()
  }

  return '0' + data.toString()
}

export const formatDate = (data: string) => {
  const date = new Date(data)
  const currentDate = new Date()
  return `${date.getDate()} ${months[date.getMonth()]} ${
    currentDate.getFullYear() !== date.getFullYear() ? date.getFullYear() : ``
  } ${date.getHours()}:${formatTime(date.getMinutes())}:${formatTime(date.getSeconds())}`
}
