
function obtenerFactura(idInscripcion) {
    fetch(`../controllers/FacturaController.php?option=verFactura&idInscripcion=${idInscripcion}`)
        .then(response => response.json())
        .then(data => {
            if (data.tipo === 'success') {
                renderFactura(data.factura);
            } else {
                alert(data.mensaje);
            }
        });
}

function renderFactura(factura) {
    const div = document.getElementById('factura-container');
    if (!div) return;

    const p = factura.participante;
    const e = factura.evento;
    const pago = factura.pago;

    const razonSocial = `${p.NOMBRES} ${p.APELLIDOS}`;
    const rucCi = p.CEDULA || "-";
    const fechaEmision = factura.fecha_emision || "-";
    const valorTotal = parseFloat(e.COSTO || 0).toFixed(2);
    const claveAcceso = factura.clave_acceso || "3110202401186504291000120031010000057220000000119";
    const descripcion = e.TITULO || "-";

    div.innerHTML = `
    <style>
        #factura-html {
            font-family: Arial, sans-serif;
            font-size: 11px;
            padding: 20mm 15mm;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            border: 1px solid #999; /* MARCO visual */
            box-sizing: border-box;
            background-color: #fff;
        }
        .logo { height: 70px; }
        .header, .section { margin-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table, .table th, .table td { border: 1px solid #000; }
        .table th, .table td { padding: 5px; text-align: left; }
        .section-title { font-weight: bold; margin-top: 20px; }
        .observaciones { font-size: 10px; margin-top: 15px; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
    </style>

    <div id="factura-html">
        <div class="text-center header">
            <img src="../public/img/uta/factura_logo.png" class="logo"><br>
            <div class="text-bold">EMPRESA PUBLICA DE LA UNIVERSIDAD TÉCNICA DE AMBATO UTA EP</div>
            RUC: 1865042910001<br>
            DIR. MATRIZ: QUITO 02-45 Y ENTRE BOLIVAR Y ROCAFUERTE<br>
            CONT. ESPECIAL No.:<br>
            OBLIGADO A LLEVAR CONTABILIDAD: SI
        </div>

        <table class="table">
            <tr>
                <td><strong>AGENTE DE RETENCIÓN:</strong> NAC-DNCRASC20-0000001</td>
                <td><strong>FACTURA No.:</strong> 003-101-000005722</td>
            </tr>
            <tr>
                <td><strong>RUC:</strong> 1865042910001</td>
                <td><strong>Ambiente:</strong> PRODUCCIÓN | <strong>Tipo de Emisión:</strong> NORMAL</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Clave de Acceso:</strong> ${claveAcceso}</td>
            </tr>
        </table>

        <div class="section">
            <strong>Razón Social / Nombres y Apellidos:</strong> ${razonSocial}<br>
            <strong>RUC/CI:</strong> ${rucCi}<br>
            <strong>Fecha de Emisión:</strong> ${fechaEmision}
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Código</th><th>Cantidad</th><th>Descripción</th><th>V/Unitario</th><th>Descuento</th><th>V/Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>EVT-${e.SECUENCIAL}</td>
                    <td>1.00</td>
                    <td>${descripcion}</td>
                    <td>${valorTotal}</td>
                    <td>0.00</td>
                    <td>${valorTotal}</td>
                </tr>
            </tbody>
        </table>

        <table class="table">
            <tr>
                <td><strong>SUBTOTAL 15%:</strong> 0.00</td>
                <td><strong>SUBTOTAL 0%:</strong> ${valorTotal}</td>
                <td><strong>SUB. No Objeto IVA:</strong> 0.00</td>
                <td><strong>SUB. sin Impuestos:</strong> ${valorTotal}</td>
            </tr>
            <tr>
                <td><strong>DESCUENTO:</strong> 0.00</td>
                <td><strong>ICE:</strong> 0.00</td>
                <td><strong>IVA 15%:</strong> 0.00</td>
                <td><strong>VALOR TOTAL:</strong> ${valorTotal}</td>
            </tr>
        </table>

        <div class="section-title">FORMAS DE PAGO</div>
        <table class="table">
            <thead>
                <tr><th>Forma de Pago</th><th>Valor</th><th>Plazo</th><th>Tiempo</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>${pago.FORMA_PAGO || 'Efectivo'}</td>
                    <td>${valorTotal}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="observaciones">
            > OBSERVACIONES: Pago tipo D del ${factura.fecha_pago || "-"} a la cuenta 111.15.01<br>
            > DIRECCIÓN: ${p.DIRECCION || '-'}<br>
            > TELÉFONO: ${p.TELEFONO || '-'}<br>
            > EMAIL: ${p.CORREO || '-'}
        </div>
    </div>
    `;
}



function descargarPDF(nombre = 'factura.pdf') {
    const factura = document.getElementById('factura-html');
    if (!factura) return;

    html2canvas(factura, {
        scale: 2,          // buena calidad
        useCORS: true,     // por si usas logos externos
        scrollY: 0         // evita scroll al capturar
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jspdf.jsPDF('p', 'mm', 'a4');

        const pageWidth = pdf.internal.pageSize.getWidth();
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pageWidth;
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        // Si la imagen excede la altura de la página, la recorta bien
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save(nombre);
    });
}
