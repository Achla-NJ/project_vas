@extends('admin.layout')
@section('css')
{{-- <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}"> --}}
<!-- Include Date Range Picker CSS from CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')

    <main class="content">
        <div class="mb-3 pt-5 pb-4">
            <h1 class="h3 d-inline align-middle">Workspace Agreement</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card company-form">
                    <div class="card-body">
                        <form method="POST" action="{{route('admin.companies.workspace-agreement.update') }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input type="hidden" name="company_id" value={{$company->id}}>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="agreement_date" class="form-label">Agreement Made On:</label>
                                        <input type="text" class="form-control" id="agreement_date" name="agreement_date" value="{{ isset($workspace_agreement->agreement_date)  ? $workspace_agreement->agreement_date->toDateString() : old('agreement_date')}}" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">Company Name:</label>
                                        <textarea name="company_name" class="form-control" cols="50" readonly>{{$company->company_name}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="company_address" class="form-label">Company Address:</label>
                                        <textarea name="company_address"  class="form-control" cols="50" readonly>{{$company->registered_address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="company_address" class="form-label">Pan Number:</label>
                                        <input type="text" id="pan_number" class="form-control" name="pan_number" value="{{$company->pan_card_no}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="mobile_number" class="form-label">Mobile Number:</label>
                                        <input type="text" id="mobile_number" class="form-control" name="mobile_number" value="{{$company->mobile_no}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="effective_from" class="form-label">Effective From:</label>
                                        <input type="text" class="form-control" id="effective_from" name="effective_from" value="{{ isset($workspace_agreement->effective_from)  ? $workspace_agreement->effective_from->toDateString() : old('effective_from')}}" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="effective_to" class="form-label">Effective To:</label>
                                        <input type="text" class="form-control" id="effective_to" name="effective_to" value="{{ isset($workspace_agreement->effective_to)  ? $workspace_agreement->effective_to->toDateString() : old('effective_to')}}" >
                                    </div>
                                </div>

                                {{-- <div class="col-md-12">
                                    <h4>THE TWO PARTIES TO THE AGREEMENT ARE AS FOLLOWS</h4>
                                    <div class="mt-4">
                                        <p>This AGREEMENT made on
                                            <input type="text" id="agreement_date" name="agreement_date" value="{{ isset($workspace_agreement->agreement_date)  ? $workspace_agreement->agreement_date->toDateString() : old('agreement_date')}}" >
                                            between Vselek Coworking and Co-ware housing Private Limited herein after referred to as Service Provider having office at N-161, SAIRA TOWER, G.F, GAUTAM NAGAR NEAR GREEN PARK METRO STATION GATE NO.2 DELHI South Delhi DL 110049 and
                                            <textarea name="company_name" cols="50" readonly>{{$company->company_name}}</textarea>
                                            through it’s <textarea name="company_address" cols="50" readonly>{{$company->registered_address}}</textarea> PAN Number
                                            <input type="text" id="pan_number" name="pan_number" value="{{$company->pan_card_no}}" readonly> with Mobile Number
                                            <input type="text" id="mobile_number" name="mobile_number" value="{{$company->mobile_no}}" readonly> here in after referred to as “Client”.
                                        </p>
                                    </div>

                                    <h4 class="mt-4">The Nature of the Agreement</h4>
                                    <div>
                                        <p>The Client is interested in using Mail Box Services in C/o Vselek Coworking and Warehousing Private Limited N-161, SAIRA TOWER, G.F, GAUTAM NAGAR NEAR GREEN PARK METRO STATION GATE NO.2 DELHI South Delhi DL 110049 for communication address/Mail Address purpose. The whole of the Premise remains the property of the Service Provider and remains in the Service Provider possession and control. </p>
                                    </div>

                                    <h4 class="mt-4">ACKNOWLEDGMENT AND ACCEPTANCE OF TERMS OF USE </h4>
                                    <div>
                                        <p>The Services are offered to client on Service providers conditioned. Client’s use of the Service constitutes its agreement to the terms and conditions stated in this Agreement.

                                            Each person that uses the Service, or enters in to a contract, in writing or online, on behalf of its employer or other third party, represents that such person is authorized to accept these terms on its employer's or on third party's behalf. Unless explicitly stated otherwise, the Terms of Service will govern the use of any new features that augment or enhance the current Services, including the release of Resources and services. In the case of any violation of these terms, Service Provider reserves the right to cancel Services to client immediately and seek all remedies available by law and in equity for such violations. Similarly, In the case of any violation of these terms by Service Provider, The Service provider reserves the right to cancel Services to client. </p>
                                    </div>
                                    <h4 class="mt-4">Usage of Address</h4>
                                    <div>
                                        <p>The Client may use the address for business correspondence.</p>
                                        <p>The client can use it as a “Principal Place of Business Address” for any / ROC Registration / GST Registrations with regard to the central /state Government or any other authorities at his own risk and liabilities in connection with the above agreement.</p>
                                    </div>
                                    <h4 class="mt-4">Rent / Subscription Fees</h4>
                                    <div>
                                        <p>Rent/Subscription Fees: The client agrees to pay the rent/subscription fees for a period of 11 months in advance to the service provider. This implies that the client pays upfront for the services to be received over the next 11 months. </p>
                                        <p>Agreement Renewal: The client must renew the agreement on the 11th month from the date of commencement. Failure to do so allows the service provider or any designated party to terminate the contract.</p>
                                        <p>Tax Invoice and Settlement: The service provider will issue a tax invoice for the services rendered in the previous month. The client is required to settle all valid invoices within 30 days of receipt.</p>
                                        <p>Termination for Non-Payment: Failure to pay the rent/subscription fees will result in the termination of services on the specified expiration date agreed upon during signup or payment.</p>
                                        <p>Late Payment Interest: In the case of late payments, the client/agreement holder may be charged an additional amount as interest. The interest rate for delays exceeding 30 days is set at 12% per annum on a pro-rata basis.</p>
                                    </div>
                                    <h4 class="mt-4">INDEMNITY</h4>
                                    <div>
                                        <p>The Client shall be responsible for compliance with all the necessary provisions of the Companies Act, GST / other relevant laws, and hereby agrees to indemnify and keep and hold Service Provider fully indemnified and harmless from and against all claims, proceedings, damages, losses, actions, costs and expenses arising as a consequence of or out of this agreement or arising from any breach of rules and regulations of any applicable law. The Client agrees not to take any loan or credit card showing the said premises as the address and the Service provider is indemnified from any liability of the Client of any manner.</p>
                                        <p>Please note that Vselek Coworking is only providing mail box services to client</p>
                                        <p>As such, Service provider do not hold any responsibility against the Client’s work. It is the Client’s responsibility to ensure that their Visitor follow our policies and guidelines while using the workspace.</p>
                                        <p>We understand that your clients may visit our coworking space to meet with you or to work on specific projects, and we welcome them as guests. However, we expect that they abide by our policies and guidelines to maintain a safe and productive workspace for all members.</p>
                                        <p>Any financial transactions between you (the client) and your clients, including payment for services or products rendered, are solely your responsibility as the service provider. Vselek Coworking assumes no responsibility for any financial transactions that occur between you and your clients</p>
                                        <p>Furthermore, if any dispute arises between you and your clients, Vselek Coworking is not responsible for resolving the dispute. It is your responsibility to handle the dispute resolution process with your clients in a professional and timely manner. </p>
                                        <p>At Vselek Coworking, we strive to maintain a professional and productive workspace for all members. We expect all members, including you and your clients, to follow our policies and guidelines to maintain a safe and productive workspace for all.</p>
                                    </div>

                                    <h4 class="mt-4">Termination of Service</h4>
                                    <div>
                                        <p>Service provider may decide to terminate the service any time with a prior notice (atleast 30 days) and Security amount will be refunded in that case. Service will be automatically terminated on the expiry date unless the subscription is renewed.</p>
                                        <p>Upon Termination of the account, the client must cease the use of Address and any Phone Numbers issued IMMEDIATLEY from all places including but not limited to business cards, websites, stationary, advertising material, Client, certificates etc.</p>
                                        <p>If the client used the Address for Registration with ROC, GST Authority, Banks etc., it has to change the address, as far as possible, within 30 days after termination of service. Service provider reserves the right to take action against those who are found in breach of this requirement.</p>
                                        <p>Service provider reserves the right to terminate the service and this agreement without notice for any client whose any illegal activity might adversely affect Service provider reputation or Service provider normal operation.</p>
                                        <p>Service provider will terminate the service anytime by a written notice of 30 days in case client Violates any clause in this agreement, or client’s activities are reported to be fraudulent.</p>
                                        <p>The client has to renew the subscription on the 11th month form the contract entered date in failure this contract will be null and void and service provider holds no responsibility, No liability for anything.</p>
                                    </div>

                                    <h4 class="mt-4">CONFIDENTIALITY</h4>
                                    <div>
                                        <p>Client recognizes that it may, in the course of obtaining or using the Services, come in to possession of or learn confidential and proprietary business information of ("Confidential Information") about service provider. Client agrees that during the Term of this Agreement and thereafter: </p>
                                        <ul>
                                            <li>Client shall provide, at a minimum, the care to avoid is closure of unauthorized use of Confidential Information as is provided with respect to Client’s own similar information, but in no event less than a reasonable standard of care. </li>
                                            <li>Client will use Confidential Information solely for the purposes of this Agreement; and </li>
                                            <li>Client will not disclose Confidential Information to any third party without the express prior written consent of service Provider. </li>
                                        </ul>
                                        <p>Similarly service provider recognizes that it may, in the course of obtaining or using the Services, come into possession of or learn confidential and proprietary business information of ("Confidential Information") about client .Service provider agrees that during the Term of this Agreement and thereafter service provider shall provide, at a minimum, the care to avoid disclosure of unauthorized use of Confidential Information office see.</p>
                                        <p>If service provider transfers its business or any business segment that provides services to client, service provider is authorized to transfer all user information to Service provider’s successor.</p>
                                    </div>

                                    <h4 class="mt-4">Ownership</h4>
                                    <div>
                                        <p>All programs, services, processes, designs, software, technologies, trademarks, trade names, inventions and materials comprising the Service are wholly owned by the Service provider.</p>
                                        <p>Service provider except where expressly stated otherwise.</p>
                                        <p>This is not a lease document. Client agrees that the client is not the service provider of any phone number assigned to them by service provider. Upon termination of account for any reason, such number may be re-assigned to another client.</p>
                                        <p>Similarly, all programs, services, processes, designs, software, technologies, trademarks, trade names, inventions and materials of the client shall be owned by the client only.</p>
                                    </div>

                                    <h4 class="mt-4">NATURE OF BUSINESS </h4>
                                    <div>
                                        <p>Client has to explain its nature of business in writing on this agreement. The client agrees with service provider not to carry on any business which could be construed illegal, defamatory, immoral, or obscene and agrees not to use the address of Service provider whether directly or indirectly for any such purpose or purposes.</p>
                                        <p>If the client changes nature of business, it must notify Service provider in writing.</p>
                                    </div>

                                    <h4 class="mt-4">CONFLICTING BUSINESS </h4>
                                    <div>
                                        <p>The client should not directly or indirectly or though agents operate a business that competes with Service provider’s business of providing serviced offices and virtual offices, shared conference rooms and meeting rooms.</p>
                                    </div>

                                    <h4 class="mt-4">GOVERNING LAW & ARBITRATION </h4>
                                    <div>
                                        <ul>
                                            <li>This Agreement shall be governed by the laws of India. The Courts in Delhi shall have exclusive jurisdiction over the subject matter of this Agreement.</li>
                                            <li>In the event of any dispute or differences arising out of or in connection with this agreement, the parties hereto, agree to resolve their dispute by a sole arbitrator chosen by the parties in FastTrack procedure under the provision of Sec 29B of Arbitration and Conciliation act of 1996. The award under this section shall be made with in a period of 6months from the date of commencement of the arbitral tribunal proceedings.</li>
                                            <li>The arbitration proceedings shall be conducted in English. The place of Arbitration shall be Delhi. The award passed in the arbitration proceedings shall be final and binding on both the parties.</li>
                                            <li>The cost of arbitration proceedings shall be equally borne by both the parties.</li>
                                            <li>Each party shall individually bear the fees of their respective Advocate/Counsel for the proceedings</li>
                                        </ul>
                                    </div>

                                    <h4 class="mt-4">ANNEXURE – 1 </h4>
                                    <div>
                                        <p>Client to describe about its nature of Business that it is planning to conduct at the Vselek’s Office in connection with this Agreement (in approx. 200 words): </p>
                                    </div>

                                    <h4 class="mt-4">PAYMENT TERMS AND TENURE AGREEMENT PERIOD: 11 Months</h4>
                                    <div>
                                        <p>Payment Rs. 10,000/- + 18% GST </p>
                                        <b>TOTAL : Rs. 11,800/-</b>
                                        <p>Effective from
                                            <input type="text" id="effective_from" name="effective_from" value="{{ isset($workspace_agreement->effective_from)  ? $workspace_agreement->effective_from->toDateString() : old('effective_from')}}" >
                                            TO
                                            <input type="text" id="effective_to" name="effective_to" value="{{ isset($workspace_agreement->effective_to)  ? $workspace_agreement->effective_to->toDateString() : old('effective_to')}}" >
                                        </p>
                                    </div>

                                    <h4 class="mt-4">Agreement is valid form</h4>
                                    <div>
                                        <p><b>Service provider’s Address is</b>: C/O Vselek Coworking and Coware housing Private Limited
                                        N-161, SAIRA TOWER, G.F, GAUTAM NAGAR NEAR GREEN PARK METRO STATION GATE NO.2 DELHI  South Delhi DL 110049 </p>
                                    </div>

                                    <h4 class="mt-4">THIS IS A FORMAL AGREEMENT ON CLIENT’S TERMS AND CONDITIONS. THIS IS NOT A LEASE OR DEED OR CAN NOT BE USED AS LEASE AGREEMENT. </h4>
                                    <div>
                                        <p>I AGREE TO THE ABOVE TERMS AND CONDITIONS.</p>
                                    </div>

                                    <h4 class="mt-4">FOR CLIENT : </h4>
                                    <div>
                                        <p>Signature: </p>
                                        <p>Name: </p>
                                        <p>Designation/Title: </p>
                                        <p>Date of Sign: </p>
                                    </div>

                                    <h4 class="mt-4">WITNESS 1 : </h4>
                                    <div>
                                        <p>Signature: </p>
                                        <p>Name: </p>
                                    </div>

                                    <h4 class="mt-4">WITNESS 2 : </h4>
                                    <div>
                                        <p>Signature: </p>
                                        <p>Name: </p>
                                    </div>

                                    <p><b>FOR Service Provider</b> (Vselek Coworking and Coware housing Private Limited) </p>

                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-6 text-end">
                                    <button type="submit" class="btn btn-success save-btn mt-2">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>

    @if(isset($workspace_agreement))
        var aggrementDate = '{{ $workspace_agreement->agreement_date->format('d-m-Y') }}';
        var effectiveFrom = '{{ $workspace_agreement->effective_from->format('d-m-Y') }}';
        var effectiveTo = '{{ $workspace_agreement->effective_to->format('d-m-Y') }}';

        $('input[name="agreement_date"]').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
            startDate: aggrementDate
        });

        $('input[name="effective_from"]').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
            startDate: effectiveFrom
        });

        $('input[name="effective_to"]').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
            startDate: effectiveTo
        });
    @else
        $('input[name="agreement_date"]').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $('input[name="effective_from"]').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $('input[name="effective_to"]').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
    @endif


</script>
@endsection
