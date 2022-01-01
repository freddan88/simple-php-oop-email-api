const contactForm = document.getElementById("contact-form");
const requiredFields = document.getElementsByClassName("field-required");

const handleApiResponse = (data) => {
  console.log(data);

  if (data.fieldErrors) {
    const { fieldErrors } = data;
    for (const fieldError in fieldErrors) {
      const formField = contactForm.elements[fieldError];
      const errorElement = formField.nextElementSibling;
      errorElement.textContent = fieldErrors[fieldError];
      formField.classList.add("field-error");
    }
  } else {
    const cssClass = data.success ? "alert-success" : "alert-danger";
    const alertBox = `<div id="form-messages" class="mt-3 alert text-center ${cssClass}" role="alert">${data.message}</div>`;
    contactForm.insertAdjacentHTML("beforebegin", alertBox);
  }

  contactForm.classList.remove("disabled");
};

const buildFormData = (event) => {
  event.preventDefault();

  const formData = new FormData(contactForm);
  contactForm.classList.add("disabled");

  formData.append("apikey", apikey);
  formData.append("emailTo", emailTo);
  formData.append("emailSubject", emailSubject);

  console.table([...formData]);

  if (useAxios) {
    axiosSendData(formData);
  } else {
    fetchSendData(formData);
  }
};

contactForm.addEventListener("submit", buildFormData);

[...requiredFields].forEach((requiredField) => {
  requiredField.addEventListener("focus", () => {
    requiredField.classList.remove("field-error");
  });
});
