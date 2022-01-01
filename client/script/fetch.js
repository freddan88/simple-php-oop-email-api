const fetchSendData = (formData) => {
  fetch(apiUrl, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => handleApiResponse(data))
    .catch((error) => {
      console.error(error.message);
      contactForm.classList.remove("disabled");
    });
};
