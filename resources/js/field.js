import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-google-places', IndexField)
  app.component('detail-google-places', DetailField)
  app.component('form-google-places', FormField)
})
