<div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="p-4">
                <form class="user" action="{{url('utilities/tarif/update',['listrik',1])}}" method="POST">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="blok1">Tarif Blok 1 <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            </div>
                            <input 
                                required
                                value="{{number_format($listrik->trf_blok1)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="blok1" 
                                id="blok1" 
                                placeholder="Tarif Blok 1" 
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="blok2">Tarif Blok 2 <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            </div>
                            <input 
                                required
                                value="{{number_format($listrik->trf_blok2)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="blok2" 
                                id="blok2"
                                placeholder="Tarif Blok 2" 
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="waktu">Waktu Kerja <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <input 
                                required
                                value="{{$listrik->trf_standar}}"
                                type="number" 
                                autocomplete="off"
                                min="1"
                                max="24"
                                class="form-control shadow"
                                name="waktu" 
                                id="waktu" 
                                placeholder="Waktu Kerja" 
                                aria-describedby="inputGroupPrepend">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Jam</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="bebanListrik">Beban Daya <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <input 
                                required
                                value="{{number_format($listrik->trf_beban)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="bebanListrik" 
                                id="bebanListrik"
                                placeholder="Beban Daya" 
                                aria-describedby="inputGroupPrepend">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Watt</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="bpju">Tarif BPJU <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <input 
                                required
                                value="{{$listrik->trf_bpju}}"
                                type="number"
                                min="0"
                                max="100" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="bpju" 
                                id="bpju"
                                placeholder="Tarif BPJU" 
                                aria-describedby="inputGroupPrepend">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="denda1">Tarif Denda 1 <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            </div>
                            <input 
                                required
                                value="{{number_format($listrik->trf_denda)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="denda1" 
                                id="denda1"
                                placeholder="Tarif Denda <= 4400" 
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="denda2">Tarif Denda 2 <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <input 
                                required
                                value="{{$listrik->trf_denda_lebih}}"
                                type="number"
                                min="0"
                                max="100" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="denda2" 
                                id="denda2"
                                placeholder="Tarif Denda > 440" 
                                aria-describedby="inputGroupPrepend">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="ppnListrik">PPN <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <input 
                                required
                                value="{{$listrik->trf_ppn}}"
                                type="number"
                                min="0"
                                max="100" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="ppnListrik" 
                                id="ppnListrik"
                                placeholder="PPN" 
                                aria-describedby="inputGroupPrepend">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="pasang">Pasang Alat <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            </div>
                            <input 
                                required
                                value="{{number_format($listrik->trf_pasang)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="pasangListrik" 
                                id="pasangListrik"
                                placeholder="Tarif Pemasangan Baru atau Ganti" 
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-primary btn-user btn-block">Simpan</button>
                    </div>
                </form>      
            </div>
        </div>
    </div>

    
<script>
document
    .getElementById('blok1')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('blok2')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('bebanListrik')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('denda1')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('pasangListrik')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
</script>