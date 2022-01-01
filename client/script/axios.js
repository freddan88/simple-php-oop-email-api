const axiosSendData = (formData) => {
  axios
    .post(apiUrl, formData)
    .then((data) => handleApiResponse(data.data))
    .catch((error) => {
      console.error(error);
      handleApiResponse(error);
      console.error(error.message);
    });
};
