import { Notification } from 'element-ui';
export function showErrors(error){
  const errors = error.response.data.errors;
  var offset = 0;
  console.log('errors:', errors);
  Object.entries(errors).forEach(([key, value]) => {
    Notification({
      type: 'error',
      title: 'Error',
      message: value[0],
      offset: offset,
    });
    offset += 60;
  });
}

export function getCurrentDate(){
  const current = new Date();
  return `${current.getFullYear()}-${current.getMonth()}-${current.getDate()}`
}