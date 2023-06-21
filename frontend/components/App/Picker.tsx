import DatePicker from 'react-datepicker'

type Props = {
  date: Date
  setDate: (v: Date) => void
}

const Picker = ({ date, setDate }: Props) => {
  return (
    <div style={{ position: 'relative' }}>
      <div style={{ position: 'absolute', right: 'calc(100% + 50px)' }}>
        <DatePicker selected={date} onChange={setDate} inline />
      </div>
    </div>
  )
}

export default Picker
