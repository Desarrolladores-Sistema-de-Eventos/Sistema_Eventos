
document.addEventListener('DOMContentLoaded', () => {
  cargarPerfilUsuario();
  cargarCarrerasYSeleccionar();

  const form = document.getElementById('form-perfil');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      actualizarPerfil();
    });
  }

  // FOTO PERFIL
  const inputFoto = document.getElementById('foto_perfil');
  const imgPreview = document.getElementById('img-perfil-preview');
  const btnFotoEditar = document.getElementById('btn-foto-editar');

  inputFoto.addEventListener('change', () => {
    const file = inputFoto.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = e => {
        imgPreview.src = e.target.result;
        inputFoto.style.display = 'none';
        btnFotoEditar.style.display = 'inline-block';
      };
      reader.readAsDataURL(file);
    }
  });

  btnFotoEditar.addEventListener('click', () => {
    inputFoto.value = '';
    inputFoto.style.display = 'block';
    btnFotoEditar.style.display = 'none';
  });

  // PDF CÉDULA
  const inputPDF = document.getElementById('cedula_pdf');
  const pdfPreview = document.getElementById('pdf-preview');
  const btnAbrirPDF = document.getElementById('btn-abrir-pdf');
  const btnEditarPDF = document.getElementById('btn-pdf-editar');

  inputPDF.addEventListener('change', () => {
    const file = inputPDF.files[0];
    if (file && file.type === 'application/pdf') {
      const url = URL.createObjectURL(file);
      btnAbrirPDF.href = url;
      inputPDF.style.display = 'none';
      pdfPreview.style.display = 'block';
    }
  });

  btnEditarPDF.addEventListener('click', () => {
    inputPDF.value = '';
    inputPDF.style.display = 'block';
    pdfPreview.style.display = 'none';
  });

  // PDF MATRÍCULA
  const inputMatricula = document.getElementById('matricula_pdf');
  const matPreview = document.getElementById('matricula-preview');
  const btnMatriculaAbrir = document.getElementById('btn-abrir-matricula');
  const btnMatriculaEditar = document.getElementById('btn-matricula-editar');

  if (inputMatricula) {
    inputMatricula.addEventListener('change', () => {
      const file = inputMatricula.files[0];
      if (file && file.type === 'application/pdf') {
        const url = URL.createObjectURL(file);
        btnMatriculaAbrir.href = url;
        inputMatricula.style.display = 'none';
        matPreview.style.display = 'block';
      }
    });

    btnMatriculaEditar?.addEventListener('click', () => {
      inputMatricula.value = '';
      inputMatricula.style.display = 'block';
      matPreview.style.display = 'none';
    });
  }
});

function cargarPerfilUsuario() {
  axios.get('../controllers/UsuarioController.php?option=perfilUsuario')
    .then(res => {
      const { success, usuario } = res.data;
      if (!success || !usuario) throw new Error('Perfil no válido');

      // Datos
      document.getElementById('nombres').value = usuario.NOMBRES || '';
      document.getElementById('apellidos').value = usuario.APELLIDOS || '';
      document.getElementById('identificacion').value = usuario.CEDULA || '';
      document.getElementById('telefono').value = usuario.TELEFONO || '';
      document.getElementById('direccion').value = usuario.DIRECCION || '';
      document.getElementById('fecha_nacimiento').value = usuario.FECHA_NACIMIENTO || '';
      document.getElementById('correo').value = usuario.CORREO || '';
      document.getElementById('rol').value = usuario.CODIGOROL || '';
      document.getElementById('estado_usuario').value = usuario.CODIGOESTADO || '';
      document.getElementById('foto_perfil_actual').value = usuario.FOTO_PERFIL_URL || '';
      document.getElementById('cedula_pdf_actual').value = usuario.CEDULA_PDF_URL || '';
      document.getElementById('matricula_pdf_actual').value = usuario.URL_MATRICULA || '';

      // Rol - mostrar campos condicionalmente
      const carreraDiv = document.getElementById('carrera')?.closest('div');
      const matriculaDiv = document.querySelector('.matricula-upload');
      if (usuario.CODIGOROL === 'INV') {
        carreraDiv.style.display = 'none';
        matriculaDiv.style.display = 'none';
      } else if (usuario.CODIGOROL === 'DOC') {
        carreraDiv.style.display = 'block';
        matriculaDiv.style.display = 'none';
      } else if (usuario.CODIGOROL === 'EST') {
        carreraDiv.style.display = 'block';
        matriculaDiv.style.display = 'flex';
      }

      // Imagen
      const img = document.getElementById('img-perfil-preview');
      const inputFoto = document.getElementById('foto_perfil');
      const btnFotoEditar = document.getElementById('btn-foto-editar');

      if (usuario.FOTO_PERFIL_URL?.trim()) {
        img.src = usuario.FOTO_PERFIL_URL;
        inputFoto.style.display = 'none';
        btnFotoEditar.style.display = 'inline-block';
      } else {
        img.src = 'assets/img/uta/profile_placeholder.png';
        inputFoto.style.display = 'block';
        btnFotoEditar.style.display = 'none';
      }

      // CÉDULA
      const pdfLink = document.getElementById('btn-abrir-pdf');
      const pdfBlock = document.getElementById('pdf-preview');
      const inputPDF = document.getElementById('cedula_pdf');
      if (usuario.CEDULA_PDF_URL?.trim()) {
        pdfLink.href = usuario.CEDULA_PDF_URL;
        pdfBlock.style.display = 'block';
        inputPDF.style.display = 'none';
      } else {
        pdfBlock.style.display = 'none';
        inputPDF.style.display = 'block';
      }

      // MATRÍCULA
      const matLink = document.getElementById('btn-abrir-matricula');
      const matBlock = document.getElementById('matricula-preview');
      const inputMat = document.getElementById('matricula_pdf');
      if (usuario.URL_MATRICULA?.trim()) {
        matLink.href = usuario.MATRICULA_PDF_URL;
        matBlock.style.display = 'block';
        inputMat.style.display = 'none';
      } else {
        matBlock.style.display = 'none';
        inputMat.style.display = 'block';
      }

      // Carrera
      if (usuario.SECUENCIALCARRERA) {
        const select = document.getElementById('carrera');
        if (select) select.value = usuario.SECUENCIALCARRERA;
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire('Error', 'No se pudo cargar el perfil del usuario.', 'error');
    });
}

function cargarCarrerasYSeleccionar() {
  const select = document.getElementById('carrera');
  if (!select) return;

  axios.get('../controllers/UsuarioController.php?option=listarCarrera')
    .then(res => {
      const { success, carreras } = res.data;
      if (!success || !Array.isArray(carreras)) throw new Error();

      select.innerHTML = '<option value="">Seleccione una carrera</option>';
      carreras.forEach(c => {
        const option = document.createElement('option');
        option.value = c.SECUENCIAL;
        option.textContent = c.NOMBRE_CARRERA;
        select.appendChild(option);
      });

      return axios.get('../controllers/UsuarioController.php?option=perfilUsuario');
    })
    .then(res => {
      const usuario = res.data.usuario;
      if (usuario?.SECUENCIALCARRERA) {
        document.getElementById('carrera').value = usuario.SECUENCIALCARRERA;
      }
    })
    .catch(() => {
      Swal.fire('Error', 'No se pudo cargar la lista de carreras.', 'error');
    });
}

function actualizarPerfil() {
  const formData = new FormData();
  formData.append('nombres', document.getElementById('nombres').value);
  formData.append('apellidos', document.getElementById('apellidos').value);
  formData.append('identificacion', document.getElementById('identificacion').value);
  formData.append('telefono', document.getElementById('telefono').value);
  formData.append('direccion', document.getElementById('direccion').value);
  formData.append('fecha_nacimiento', document.getElementById('fecha_nacimiento').value);
  formData.append('correo', document.getElementById('correo').value);
  formData.append('rol', document.getElementById('rol').value);
  formData.append('estado_usuario', document.getElementById('estado_usuario').value);

  const carrera = document.getElementById('carrera');
  if (carrera) formData.append('carrera', carrera.value);

  const foto = document.getElementById('foto_perfil');
  const fotoActual = document.getElementById('foto_perfil_actual').value;
  if (foto && foto.files.length > 0) {
    formData.append('foto_perfil', foto.files[0]);
  } else {
    formData.append('foto_perfil_actual', fotoActual);
  }

  const cedula = document.getElementById('cedula_pdf');
  const cedulaActual = document.getElementById('cedula_pdf_actual').value;
  if (cedula && cedula.files.length > 0) {
    formData.append('cedula_pdf', cedula.files[0]);
  } else {
    formData.append('cedula_pdf_actual', cedulaActual);
  }

  const matricula = document.getElementById('matricula_pdf');
  const matriculaActual = document.getElementById('matricula_pdf_actual').value;
  if (matricula && matricula.files.length > 0) {
    formData.append('matricula_pdf', matricula.files[0]);
  } else {
    formData.append('matricula_pdf_actual', matriculaActual);
  }

  axios.post('../controllers/UsuarioController.php?option=actualizarPerfilUsuario', formData)
    .then(res => {
      if (res.data.success) {
        Swal.fire('Éxito', 'Perfil actualizado correctamente.', 'success');
        //cargarPerfilUsuario(); // Recargar datos actualizados
      } else {
        throw new Error(res.data.mensaje || 'Error al actualizar perfil');
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire('Error', 'No se pudo actualizar el perfil.', 'error');
    });
}
