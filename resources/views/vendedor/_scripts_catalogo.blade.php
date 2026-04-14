<script>
    let maxStockActual = 0;
    let tCambioActual = 6.96;

    function openVentaModal(prod, stockDisp, tCambio) {
        maxStockActual = stockDisp;
        tCambioActual = tCambio;

        document.getElementById('input_pm_id').value = prod.pm_id; 
        document.getElementById('confirmarNombre').innerText = prod.descripcion || prod.codigo_interno;
        document.getElementById('confirmarMaxStock').innerText = stockDisp;
        
        document.getElementById('input_cantidad').value = 1;
        document.getElementById('labelPrecioRegistro').innerText = parseFloat(prod.precio_lista_dolares).toFixed(2);
        document.getElementById('input_precio').value = prod.precio_lista_dolares;
        
        actualizarTotal();

        const modal = document.getElementById('modalConfirmarVenta');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeVentaModal() {
        document.getElementById('modalConfirmarVenta').classList.add('hidden');
        document.getElementById('modalConfirmarVenta').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function validarStockYCalcular() {
        let input = document.getElementById('input_cantidad');
        let val = parseInt(input.value);

        if (isNaN(val) || val < 1) {
            actualizarTotal();
            return;
        }

        if (val > maxStockActual) {
            alert("No puedes vender más del stock disponible (" + maxStockActual + ")");
            input.value = maxStockActual;
        }
        actualizarTotal();
    }

    function changeQty(val) {
        let input = document.getElementById('input_cantidad');
        let newVal = (parseInt(input.value) || 0) + val;
        if(newVal >= 1 && newVal <= maxStockActual) {
            input.value = newVal;
            actualizarTotal();
        }
    }

    function actualizarTotal() {
        let cant = parseFloat(document.getElementById('input_cantidad').value) || 0;
        let precio = parseFloat(document.getElementById('input_precio').value) || 0;
        
        let totalUSD = cant * precio;
        let totalBS = totalUSD * tCambioActual;

        document.getElementById('labelTotal').innerText = '$' + totalUSD.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('labelTotalBS').innerText = totalBS.toLocaleString('es-BO', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' Bs';
    }

    function openModal(prod) {
        document.getElementById('modalTipo').innerText = '// ' + prod.tipo;
        document.getElementById('modalCodigo').innerText = prod.codigo_interno;
        document.getElementById('modalDesc').innerText = prod.descripcion || 'Sin descripción adicional';
        
        let specsHtml = '';
        if(prod.tipo === 'bendix') {
            specsHtml = `
                ${renderSpec('Marca', prod.marca_nombre)}
                ${renderSpec('ZEN', prod.codigo_zen)}
                ${renderSpec('Dientes', prod.dientes)}
                ${renderSpec('Estrías', prod.b_estrias)}
                ${renderSpec('Largo', prod.b_largo + ' mm')}
                ${renderSpec('Ø Ext', prod.diametro_externo + ' mm')}
                ${renderSpec('Ø Int', (prod.diametro_interno || 'N/A') + ' mm')}
                ${renderSpec('Sentido', prod.sentido)}
            `;
        } else if(prod.tipo === 'inducido') {
            specsHtml = `
                ${renderSpec('Marca', prod.marca_nombre)}
                ${renderSpec('Voltaje', prod.i_voltaje + 'V')}
                ${renderSpec('Estrías', prod.i_estrias)}
                ${renderSpec('Largo', prod.i_largo + ' mm')}
                ${renderSpec('Ø Ext', prod.i_diametro + ' mm')}
                ${renderSpec('Delgas', prod.delgas)}
                ${renderSpec('Cod. Orig.', prod.codigo_original)}
            `;
        } else if(prod.tipo === 'regulador') {
            specsHtml = `
                ${renderSpec('Marca', prod.marca_nombre)}
                ${renderSpec('Sistema', prod.r_sistema)}
                ${renderSpec('Voltaje', prod.r_voltaje + 'V')}
                ${renderSpec('Terminales', prod.terminales)}
                ${renderSpec('Circuito', prod.circuito)}
                ${renderSpec('Capacitor', prod.capacitor ? 'Sí' : 'No')}
            `;
        }

        document.getElementById('modalSpecs').innerHTML = specsHtml;
        const modal = document.getElementById('modalDetalles');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('modalDetalles').classList.add('hidden');
        document.getElementById('modalDetalles').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function openImageModal(url, ref) {
        const modal = document.getElementById('modalImagen');
        const img = document.getElementById('imgZoom');
        const label = document.getElementById('imgZoomRef');
        img.src = url;
        label.innerText = 'REF: ' + ref;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('modalImagen').classList.add('hidden');
        document.getElementById('modalImagen').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function renderSpec(label, value) {
        if(!value) return '';
        return `
            <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-800">
                <p class="text-[9px] text-custom-brand font-black uppercase tracking-tighter mb-1">${label}</p>
                <p class="font-bold text-lg leading-none">${value}</p>
            </div>
        `;
    }

    window.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
            closeImageModal();
            closeVentaModal();
        }
    });

    // --- MEJORA: Lógica de SweetAlert2 para Success/Error ---
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '<span style="color:#fff; font-family:italic; font-weight:900;">TRANSACCIÓN EXITOSA</span>',
                html: '<span style="color:#a0aec0;">{{ session("success") }}</span>',
                background: '#111419',
                iconColor: '#10b981',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                backdrop: `rgba(0,0,0,0.6) blur(4px)`,
                customClass: {
                    popup: 'rounded-[2rem] border border-gray-800 shadow-2xl',
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '<span style="color:#fff;">ERROR</span>',
                text: '{{ session("error") }}',
                background: '#111419',
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'rounded-[2rem] border border-gray-800'
                }
            });
        @endif
    });
</script>

<style>
    .vertical-text { writing-mode: vertical-rl; text-orientation: mixed; }
    #imgZoom { user-select: none; -webkit-user-drag: none; }
    #modalDetalles > div:last-child, #modalImagen > div:last-child, #modalConfirmarVenta > div:last-child, #modalConfirmarVenta > form {
        animation: modalAppear 0.3s ease-out;
    }
    @keyframes modalAppear {
        from { opacity: 0; transform: scale(0.95) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {
        -webkit-appearance: none; margin: 0;
    }
</style>