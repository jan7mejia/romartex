{{-- MODAL DE CONFIRMACIÓN DE VENTA --}}
<div id="modalConfirmarVenta" class="fixed inset-0 z-[120] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/90 backdrop-blur-md" onclick="closeVentaModal()"></div>
    <div class="bg-[#111419] border border-gray-800 w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden transform transition-all">
        <form action="{{ route('vendedor.venta.store') }}" method="POST" id="formVenta">
            @csrf
            <input type="hidden" name="producto_marca_id" id="input_pm_id">
            
            <div class="p-8 border-b border-gray-800 bg-gradient-to-r from-custom-brand/20 to-transparent">
                <h2 class="text-2xl font-black text-white italic uppercase tracking-tighter">Confirmar Transacción</h2>
                <p id="confirmarNombre" class="text-gray-400 text-sm mt-1 font-bold uppercase tracking-widest"></p>
            </div>

            <div class="p-8 space-y-5">
                {{-- Cantidad --}}
                <div>
                    <label class="text-xs font-black text-custom-brand uppercase tracking-widest mb-2 block">Cantidad a Vender</label>
                    <div class="flex items-center gap-4 bg-black/50 border border-gray-800 rounded-2xl p-2">
                        <button type="button" onclick="changeQty(-1)" class="w-12 h-12 flex items-center justify-center bg-gray-800 rounded-xl text-white font-black hover:bg-custom-brand hover:text-black transition-all">-</button>
                        <input type="number" name="cantidad" id="input_cantidad" value="1" min="1" oninput="validarStockYCalcular()" class="flex-grow bg-transparent text-center text-3xl font-black text-white outline-none">
                        <button type="button" onclick="changeQty(1)" class="w-12 h-12 flex items-center justify-center bg-gray-800 rounded-xl text-white font-black hover:bg-custom-brand hover:text-black transition-all">+</button>
                    </div>
                    <p class="text-[11px] text-gray-500 mt-2 italic font-bold text-center">Stock disponible: <span id="confirmarMaxStock" class="text-white"></span> unidades</p>
                </div>

                {{-- Precio de Registro (Fijo) --}}
                <div>
                    <label class="text-xs font-black text-gray-500 uppercase tracking-widest mb-2 block italic">Precio de Registro (Referencia)</label>
                    <div class="w-full bg-white/5 border border-white/5 rounded-2xl p-4 flex justify-between items-center opacity-60">
                        <span class="text-gray-400 font-bold text-lg">$</span>
                        <span id="labelPrecioRegistro" class="text-2xl font-black text-gray-300 tracking-tighter">0.00</span>
                    </div>
                </div>

                {{-- Precio Final (Regatear) --}}
                <div>
                    <label class="text-xs font-black text-custom-brand uppercase tracking-widest mb-2 block">Precio Unitario Final ($USD)</label>
                    <input type="number" step="0.01" name="precio_final" id="input_precio" oninput="actualizarTotal()" class="w-full bg-black/50 border border-gray-800 rounded-2xl p-4 text-2xl font-black text-white focus:border-custom-brand outline-none transition-all">
                    <p class="text-[11px] text-gray-500 mt-2 italic text-right">Ajustable para regateo.</p>
                </div>

                {{-- Resumen con Conversión a Bolivianos --}}
                <div class="bg-custom-brand/5 border border-custom-brand/20 rounded-2xl p-5 space-y-1">
                    <div class="flex justify-between items-end">
                        <span class="text-gray-400 text-xs font-black uppercase">Cobro Total</span>
                        <span id="labelTotal" class="text-4xl font-black text-custom-brand tracking-tighter">$0.00</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-custom-brand/10 pt-2">
                        <span class="text-gray-500 text-[11px] font-bold uppercase italic">En Bolivianos</span>
                        <span id="labelTotalBS" class="text-xl font-black text-white/80 tracking-tighter">0.00 Bs</span>
                    </div>
                </div>
            </div>

            <div class="p-8 pt-0 grid grid-cols-2 gap-4">
                <button type="button" onclick="closeVentaModal()" class="py-4 rounded-xl border border-gray-800 text-gray-400 font-black uppercase text-sm hover:bg-gray-800 transition-all">Cancelar</button>
                <button type="submit" class="py-4 rounded-xl bg-custom-brand text-black font-black uppercase text-sm hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] transition-all">Finalizar Venta</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL DE DETALLES TÉCNICOS --}}
<div id="modalDetalles" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="bg-[#111419] border border-gray-800 w-full max-w-2xl rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden transform transition-all">
        <div class="p-8 border-b border-gray-800 flex justify-between items-center bg-gradient-to-r from-gray-900 to-[#111419]">
            <div>
                <span id="modalTipo" class="text-custom-brand font-black text-sm uppercase tracking-[0.3em]"></span>
                <h2 id="modalCodigo" class="text-4xl font-black text-white italic uppercase tracking-tighter"></h2>
            </div>
            <button onclick="closeModal()" class="text-gray-500 hover:text-white transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18"></path></svg>
            </button>
        </div>
        <div class="p-8">
            <div id="modalSpecs" class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-white"></div>
            <div class="mt-8 p-6 bg-white/5 rounded-2xl border border-white/5">
                <p class="text-gray-500 text-xs font-black uppercase tracking-widest mb-2">Descripción General</p>
                <p id="modalDesc" class="text-gray-300 italic text-base"></p>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DE VISUALIZACIÓN DE IMAGEN --}}
<div id="modalImagen" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/95 backdrop-blur-md" onclick="closeImageModal()"></div>
    <div class="relative z-20 max-w-4xl w-full flex flex-col items-center">
        <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-custom-brand transition-colors flex items-center gap-2 font-black uppercase text-sm tracking-widest">
            Cerrar Esc
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18"></path></svg>
        </button>
        <div class="bg-[#1c2128] p-4 rounded-[2rem] border border-gray-800 shadow-2xl overflow-hidden relative group">
            <img id="imgZoom" src="" class="max-h-[75vh] w-auto object-contain rounded-xl shadow-2xl transform transition-transform duration-500 group-hover:scale-[1.02]">
            <div class="absolute bottom-6 left-6 right-6 flex justify-between items-center pointer-events-none">
                <span id="imgZoomRef" class="bg-black/80 backdrop-blur-md text-custom-brand font-mono text-xs px-4 py-2 rounded-full border border-custom-brand/30 shadow-2xl"></span>
                <span class="bg-white/10 backdrop-blur-md text-white/50 text-[11px] font-black uppercase px-4 py-2 rounded-full border border-white/10">ROMARTEX_HD_VIEW</span>
            </div>
        </div>
    </div>
</div>