{{-- 

/**
*
* Created a new component <x-rtl.widgets._w-hybrid-one/>.
* 
*/

--}}


<div class="row widget-statistic">
    <a id="pay_carrega" href="{{getRouterValue();}}/aluno/pay/list/{{Auth()->user()->id}}" onclick="aguarde()" class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="widget widget-one_hybrid widget-followers">
            <div class="widget-heading">
                <div class="w-title">
                    <div class="w-icon">
                        <x-widgets._w-svg svg="cash"/> 
                    </div>
                    <div class="">
                        <p class="w-value">Pagamentos</p>
                        <h5 class="">Acompanhe seus pagamentos</h5>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <div id="pay_aguarde" class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-followers">
            <div class="widget-heading">
                <div class="w-title">
                    <div class="w-icon">
                        <x-widgets._w-svg svg="cash"/> 
                    </div>
                    <div class="">
                            
                        <p class="w-value"><div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Buscando...</p>
                        <h5 class="">Aguarde o carregamento</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-referral">
            <div class="widget-heading">
                <div class="w-title">
                    <div class="w-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                    </div>
                    <div class="">
                        <p class="w-value">1,900</p>
                        <h5 class="">Referral</h5>
                    </div>
                </div>
            </div>
            <div class="widget-content">    
                <div class="w-chart">
                    <div id="hybrid_followers1"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-engagement">
            <div class="widget-heading">
                <div class="w-title">
                    <div class="w-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    </div>
                    <div class="">
                        <p class="w-value">18.2%</p>
                        <h5 class="">Engagement</h5>
                    </div>
                </div>
            </div>
            <div class="widget-content">    
                <div class="w-chart">
                    <div id="hybrid_followers3"></div>
                </div>
            </div>
        </div>
    </div>--}}
</div>
<script>
    function mostrar(){
                    $('#pay_aguarde').show();
                    $("#pay_carrega").hide();
                }
                $(document).ready(function() {
                    $("#pay_aguarde").hide();
                $('#pay_carrega').click(function(event) {
                    // Sua função a ser executada quando o formulário for enviado
                    $('#pay_carrega').hide();
                    $("#pay_aguarde").show();
                    
                });
                });

</script>