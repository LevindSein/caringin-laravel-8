<div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="p-4">
                <form class="user" action="{{url('utilities/tarif/update',['airbersih',1])}}" method="POST">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="tarif1">Tarif 1 <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            </div>
                            <input 
                                required
                                value="{{number_format($airbersih->trf_1)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="tarif1" 
                                id="tarif1" 
                                placeholder="Pemakaian <= 10 M<sup>3</sup>"
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="tarif2">Tarif 2 <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            </div>
                            <input 
                                required
                                value="{{number_format($airbersih->trf_2)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="tarif2" 
                                id="tarif2"
                                placeholder="Pemakaian > 10 M<sup>3</sup>" 
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="pemeliharaan">Tarif Pemeliharaan <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">RP.</span>
                            </div>
                            <input 
                                required
                                value="{{number_format($airbersih->trf_pemeliharaan)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="pemeliharaan" 
                                id="pemeliharaan" 
                                placeholder="Waktu Kerja" 
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="bebanAir">Tarif Beban <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            </div>
                            <input 
                                required
                                value="{{number_format($airbersih->trf_beban)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="bebanAir" 
                                id="bebanAir"
                                placeholder="Beban Air" 
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="arkot">Tarif Air Kotor <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <input 
                                required
                                value="{{$airbersih->trf_arkot}}"
                                type="number"
                                min="0"
                                max="100"
                                autocomplete="off" 
                                class="form-control shadow"
                                name="arkot" 
                                id="arkot"
                                placeholder="Tarif Air Kotor" 
                                aria-describedby="inputGroupPrepend">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="dendaAir">Tarif Denda <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            </div>
                            <input 
                                required
                                value="{{number_format($airbersih->trf_denda)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="dendaAir" 
                                id="dendaAir"
                                placeholder="Tarif Denda Air" 
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="ppnAir">PPN <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <input 
                                required
                                value="{{$airbersih->trf_ppn}}"
                                type="number"
                                min="0"
                                max="100"
                                autocomplete="off" 
                                class="form-control shadow"
                                name="ppnAir" 
                                id="ppnAir"
                                placeholder="PPN" 
                                aria-describedby="inputGroupPrepend">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="pasangAir">Pasang Alat <span style="color:red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            </div>
                            <input 
                                required
                                value="{{number_format($airbersih->trf_pasang)}}"
                                type="text" 
                                autocomplete="off" 
                                class="form-control shadow"
                                name="pasangAir" 
                                id="pasangAir"
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
    .getElementById('tarif1')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('tarif2')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('pemeliharaan')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('bebanAir')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('dendaAir')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('pasangAir')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
</script>