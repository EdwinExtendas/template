// v = value of the field
export default {
    required: [ v => !!v || 'This field is required' ],
    text: [
        v => !!v || 'This field is required',
        v => (v && v.length < 255) || 'Name must be less than 255 characters'
    ],
    email: [
        v => !!v || 'E-mail is required',
        v => /.+@.+/.test(v) || 'E-mail must be valid'
    ],
    checkbox : [v => !!v || 'You must agree to continue!'],
    items: [v => !!v || 'Item is required']
}
