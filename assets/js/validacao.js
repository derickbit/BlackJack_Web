function showError(input, message) {
  const errorElement = document.createElement("span");
  errorElement.className = "error";
  errorElement.style.color = "red";
  errorElement.textContent = message;

  const previousError = input.parentElement.querySelector(".error");
  if (previousError) {
    previousError.remove();
  }

  input.parentElement.appendChild(errorElement);
}

function clearErrors(form) {
  const errors = form.querySelectorAll(".error");
  errors.forEach((error) => error.remove());
}

function isValidEmail(email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}

function validateCadastro(event) {
  const form = document.getElementById("form_cadastro");
  clearErrors(form);

  const nome = document.getElementById("nome");
  const email = document.getElementById("email");
  const senha = document.getElementById("senha");
  let isValid = true;

  if (nome.value.trim() === "" || nome.value.length > 10) {
    showError(nome, "Nome deve ter no máximo 10 caracteres.");
    isValid = false;
  }

  if (!isValidEmail(email.value)) {
    showError(email, "Por favor, insira um e-mail válido.");
    isValid = false;
  }

  if (senha.value.length < 3) {
    showError(senha, "Senha deve ter no mínimo 3 caracteres.");
    isValid = false;
  }

  if (!isValid) {
    event.preventDefault();
  }
}

function validateLogin(event) {
  const form = document.getElementById("form_login");
  clearErrors(form);

  const email = document.getElementById("email");
  const senha = document.getElementById("senha");
  let isValid = true;

  if (!isValidEmail(email.value)) {
    showError(email, "Por favor, insira um e-mail válido.");
    isValid = false;
  }

  if (senha.value.length < 3) {
    showError(senha, "Senha deve ter no mínimo 3 caracteres.");
    isValid = false;
  }

  if (!isValid) {
    event.preventDefault();
  }
}

function validateEditarPerfil(event) {
  const form = document.getElementById("form_editar_perfil");
  clearErrors(form);

  const nome = form.querySelector('input[name="nome"]');
  const email = form.querySelector('input[name="email"]');
  const senha = form.querySelector('input[name="senha"]');
  let isValid = true;

  if (nome.value.trim() === "" || nome.value.length > 10) {
    showError(nome, "Nome deve ter no máximo 10 caracteres.");
    isValid = false;
  }

  if (!isValidEmail(email.value)) {
    showError(email, "Por favor, insira um e-mail válido.");
    isValid = false;
  }

  if (senha.value.length < 3) {
    showError(senha, "Senha deve ter no mínimo 3 caracteres.");
    isValid = false;
  }

  if (!isValid) {
    event.preventDefault();
  }
}

function validateDenuncia(event) {
  const form = document.getElementById("form_denunciar_jogador");
  clearErrors(form);

  const descricao = document.getElementById("descricao");
  let isValid = true;

  if (descricao.value.trim() === "" || descricao.value.length > 300) {
    showError(descricao, "Descrição deve ter no máximo 300 caracteres.");
    isValid = false;
  }

  if (!isValid) {
    event.preventDefault();
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const formCadastro = document.getElementById("form_cadastro");
  const formLogin = document.getElementById("form_login");
  const formEditarPerfil = document.getElementById("form_editar_perfil");
  const formDenuncia = document.getElementById("form_denunciar_jogador");

  if (formCadastro) {
    formCadastro.addEventListener("submit", validateCadastro);
  }

  if (formLogin) {
    formLogin.addEventListener("submit", validateLogin);
  }

  if (formEditarPerfil) {
    formEditarPerfil.addEventListener("submit", validateEditarPerfil);
  }

  if (formDenuncia) {
    formDenuncia.addEventListener("submit", validateDenuncia);
  }
});
