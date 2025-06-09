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

      
      // Imagen
const img = document.getElementById('img-perfil-preview');
const inputFoto = document.getElementById('foto_perfil');
const btnFotoEditar = document.getElementById('btn-foto-editar');

if (usuario.FOTO_PERFIL_URL?.trim()) {
  img.src = usuario.FOTO_PERFIL_URL;
  if (inputFoto && btnFotoEditar) {
    inputFoto.style.display = 'none';
    btnFotoEditar.style.display = 'inline-block';
  }
} else {
  img.src = 'assets/img/profile_placeholder.png';
  if (inputFoto && btnFotoEditar) {
    inputFoto.style.display = 'block';
    btnFotoEditar.style.display = 'none';
  }
}


      // PDF
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

  const nombres = document.getElementById('nombres').value.trim();
  const apellidos = document.getElementById('apellidos').value.trim();
  const identificacion = document.getElementById('identificacion').value.trim();
  const telefono = document.getElementById('telefono').value.trim();
  const fechaNacimiento = document.getElementById('fecha_nacimiento').value;

  // Validaciones
  if (!nombres || !apellidos || !identificacion) {
    Swal.fire('⚠️ Atención', 'Por favor, complete todos los campos obligatorios.', 'warning');
    return;
  }

  if (!/^\d{10}$/.test(identificacion)) {
    Swal.fire('⚠️ Atención', 'La cédula debe tener 10 dígitos numéricos.', 'warning');
    return;
  }

  if (telefono && !/^\d{10}$/.test(telefono)) {
    Swal.fire('⚠️ Atención', 'El teléfono debe tener 10 dígitos numéricos.', 'warning');
    return;
  }

  if (fechaNacimiento) {
    const hoy = new Date();
    const nacimiento = new Date(fechaNacimiento);
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mes = hoy.getMonth() - nacimiento.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
      edad--;
    }
    if (edad < 18) {
      Swal.fire('⚠️ Atención', 'Debes tener al menos 18 años.', 'warning');
      return;
    }
  }


  const carrera = document.getElementById('carrera');
  if (carrera) formData.append('carrera', carrera.value);

  const foto = document.getElementById('foto_perfil');
  if (foto && foto.files.length > 0) {
    formData.append('foto_perfil', foto.files[0]);
  }

  const cedula = document.getElementById('cedula_pdf');
  if (cedula && cedula.files.length > 0) {
    formData.append('cedula_pdf', cedula.files[0]);
  }

  axios.post('../controllers/UsuarioController.php?option=actualizarPerfilUsuario', formData)
    .then(res => {
      if (res.data.success) {
        Swal.fire('✅ Éxito', 'Perfil actualizado correctamente.', 'success');
        cargarPerfilUsuario(); // Recargar vista
      } else {
        throw new Error(res.data.mensaje || 'Error al actualizar perfil');
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire('Error', 'No se pudo actualizar el perfil.', 'error');
    });
}
