@extends('themes.basic.user.layouts.app')
@section('title', translate('Tickets'))
@section('breadcrumbs', Breadcrumbs::render('user.tickets.index'))
@section('create', route('user.tickets.create'))
@section('content')
    @if ($tickets->count() > 0 || request()->input('search') || request()->input('status'))
        <div class="mb-3">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xxl-2 g-3">
                <div class="col">
                    <div class="box box-padding h-100">
                        <div class="counter counter-green">
                            <div class="counter-icon">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div class="counter-info">
                                <h5 class="counter-title">{{ translate('Opened Tickets') }}</h5>
                                <p class="counter-text">{{ number_format($counters['opened_tickets']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="box box-padding h-100">
                        <div class="counter counter-red">
                            <div class="counter-icon">
                                <i class="fa-regular fa-circle-xmark"></i>
                            </div>
                            <div class="counter-info">
                                <h5 class="counter-title">{{ translate('Closed Tickets') }}</h5>
                                <p class="counter-text">{{ number_format($counters['closed_tickets']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-table">
            <div class="table-search">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row g-3 aligs-items-center">
                        <div class="col-12 col-lg-6 col-xxl-7">
                            <input type="text" name="search" placeholder="{{ translate('Search...') }}"
                                class="form-control form-control-md" value="{{ request('search') }}">
                        </div>
                        <div class="col-12 col-lg-3 col-xxl-3">
                            <select name="status" class="selectpicker selectpicker-md" title="{{ translate('Status') }}">
                                @foreach (\App\Models\Ticket::getStatusOptions() as $key => $value)
                                    <option value="{{ $key }}" @selected(request('status') == $key)>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary w-100 btn-md"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col">
                            <a href="{{ url()->current() }}" class="btn btn-outline-primary w-100 btn-md"><i
                                    class="fa-solid fa-rotate"></i></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-container">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>{{ translate('Ticket ID') }}</th>
                            <th class="text-start">{{ translate('Subject') }}</th>
                            <th class="text-center">{{ translate('Category') }}</th>
                            <th class="text-center">{{ translate('Status') }}</th>
                            <th>{{ translate('Created Date') }}</th>
                            <th class="text-end">{{ translate('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>
                                    <a href="{{ route('user.tickets.show', $ticket->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>
                                        {{ $ticket->id }}
                                    </a>
                                </td>
                                <td class="text-start">
                                    <a href="{{ route('user.tickets.show', $ticket->id) }}" class="text-dark">
                                        {{ shorterText($ticket->subject, 30) }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    {{ $ticket->category->name }}
                                </td>
                                <td class="text-center">
                                    @if ($ticket->isOpened())
                                        <span class="badge bg-green rounded-2 fw-light px-3 py-2">
                                            {{ $ticket->getStatusName() }}
                                        </span>
                                    @else
                                        <span class="badge bg-red rounded-2 fw-light px-3 py-2">
                                            {{ $ticket->getStatusName() }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ dateFormat($ticket->created_at) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('user.tickets.show', $ticket->id) }}" class="btn btn-primary">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="text-muted p-4">{{ translate('No data found') }}</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $tickets->links() }}
        @push('styles_libs')
            <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        @endpush
    @else
        <div class="box box-empty">
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="180px" height="180px" viewBox="0 0 648.36337 565.55088"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path
                        d="M734.01347,731.78472H719.25371a6.50737,6.50737,0,0,1-6.5-6.5V602.27056a6.50736,6.50736,0,0,1,6.5-6.5h14.75976a6.50736,6.50736,0,0,1,6.5,6.5V725.28472A6.50737,6.50737,0,0,1,734.01347,731.78472Z"
                        transform="translate(-275.81831 -167.22456)" fill="{{ $themeSettings->colors->primary_color }}" />
                    <path
                        d="M704.82109,731.78472H690.06157a6.50737,6.50737,0,0,1-6.5-6.5V602.27056a6.50736,6.50736,0,0,1,6.5-6.5h14.75952a6.50736,6.50736,0,0,1,6.5,6.5V725.28472A6.50737,6.50737,0,0,1,704.82109,731.78472Z"
                        transform="translate(-275.81831 -167.22456)" fill="{{ $themeSettings->colors->primary_color }}" />
                    <path
                        d="M665.89633,611.80755s-5.57626,50.14384,50.71914,48.44087,34.39288-50.97452,34.39288-50.97452-11.76453-9.24526-41.50286-.30368S665.89633,611.80755,665.89633,611.80755Z"
                        transform="translate(-275.81831 -167.22456)" fill="#ccc" />
                    <path
                        d="M690.08818,525.97075a13.80029,13.80029,0,0,1-7.63916-2.30127l-96.42773-63.82031a6.5074,6.5074,0,0,1-1.833-9.00781l8.146-12.30762a6.49968,6.49968,0,0,1,9.00782-1.833l96.42773,63.81983a13.87665,13.87665,0,0,1-7.68164,25.45019Z"
                        transform="translate(-275.81831 -167.22456)" fill="{{ $themeSettings->colors->primary_color }}" />
                    <circle cx="431.77822" cy="249.16734" r="51" fill="{{ $themeSettings->colors->primary_color }}" />
                    <path
                        d="M713.559,437.80083c-3.30591-.0918-7.42029-.20654-10.59-2.522a8.13268,8.13268,0,0,1-3.20007-6.07276,5.47081,5.47081,0,0,1,1.86035-4.49315c1.65552-1.39894,4.073-1.72706,6.67822-.96144l-2.69922-19.72558,1.98145-.27149,3.17321,23.19-1.65466-.75928c-1.91833-.87988-4.55163-1.32764-6.188.05517a3.51516,3.51516,0,0,0-1.15271,2.89551,6.14685,6.14685,0,0,0,2.38123,4.52783c2.46667,1.80176,5.74621,2.03418,9.46582,2.13819Z"
                        transform="translate(-275.81831 -167.22456)" fill="#2f2e41" />
                    <rect x="409.21921" y="238.50254" width="10.77161" height="2" fill="#2f2e41" />
                    <rect x="443.21921" y="238.50254" width="10.77161" height="2" fill="#2f2e41" />
                    <path
                        d="M759.11287,622.37243s4.40337-149.71476-57.24388-139.44022-35.9609,154.852-35.9609,154.852,13.21012,26.42025,45.50154-2.93559S759.11287,622.37243,759.11287,622.37243Z"
                        transform="translate(-275.81831 -167.22456)" fill="#2f2e41" />
                    <path
                        d="M597.88408,602.62993a6.51042,6.51042,0,0,1-5.94068-3.83935l-6.041-13.4668a6.49946,6.49946,0,0,1,3.27026-8.59082l105.50464-47.32959a13.87944,13.87944,0,1,1,11.36182,25.32715L600.53471,602.0606A6.46381,6.46381,0,0,1,597.88408,602.62993Z"
                        transform="translate(-275.81831 -167.22456)" fill="{{ $themeSettings->colors->primary_color }}" />
                    <path
                        d="M736.36245,373.31535c-9.92325-6.73767-22.44776-2.16056-32.09,2.6478-9.3644,4.66977-19.91679,10.61158-30.51238,6.11347-4.138-1.75667-7.50133-5.19279-8.08592-9.79017-.69638-5.47656,2.61539-10.60359,6.29858-14.32714a45.87753,45.87753,0,0,1,13.76536-9.072,64.33515,64.33515,0,0,1,15.66789-4.76416,68.19059,68.19059,0,0,1,59.581,18.73142,75.54779,75.54779,0,0,1,21.42528,58.07187c-.84263,11.34533-4.466,22.91386-11.73538,31.82006-6.82041,8.35617-17.0332,14.23085-27.93323,14.72129a31.33484,31.33484,0,0,1-7.96241-.64674c-1.883-.40151-2.6877,2.48979-.79752,2.89284,11.35259,2.42073,23.11306-1.176,32.11706-8.25837,9.47848-7.45555,15.29417-18.74246,17.844-30.372,4.8795-22.25517-1.23331-46.2054-15.24162-64.02188a69.79587,69.79587,0,0,0-26.11761-20.60929,72.50758,72.50758,0,0,0-33.6916-6.1824,67.10442,67.10442,0,0,0-32.47908,10.29118c-8.73053,5.64224-18.57033,17.603-11.45,28.18545,2.66262,3.95724,7.08293,6.36786,11.67193,7.35844a28.651,28.651,0,0,0,15.72391-1.36974c11.40638-4.02781,21.95577-13.02788,34.72307-11.664a16.9312,16.9312,0,0,1,7.76458,2.83449c1.60146,1.08736,3.10414-1.51085,1.51416-2.59041Z"
                        transform="translate(-275.81831 -167.22456)" fill="#2f2e41" />
                    <path
                        d="M562.22612,556.49614a3.89177,3.89177,0,0,1-3.02344-1.44873l-16.58569-20.272H300.18169a9.01031,9.01031,0,0,1-9-9v-144a9.01031,9.01031,0,0,1,9-9h257a9.01032,9.01032,0,0,1,9,9V552.55571a3.89253,3.89253,0,0,1-2.61133,3.70508A3.98635,3.98635,0,0,1,562.22612,556.49614ZM300.18169,374.77544a7.00786,7.00786,0,0,0-7,7v144a7.00786,7.00786,0,0,0,7,7H543.56474l17.18579,21.00537a1.93425,1.93425,0,0,0,3.43116-1.2251V381.77544a7.00787,7.00787,0,0,0-7-7Z"
                        transform="translate(-275.81831 -167.22456)" fill="#3f3d56" />
                    <path d="M528.18169,420.77544h-199a5,5,0,0,1,0-10h199a5,5,0,0,1,0,10Z"
                        transform="translate(-275.81831 -167.22456)" fill="#ccc" />
                    <path d="M528.18169,453.77544h-199a5,5,0,0,1,0-10h199a5,5,0,0,1,0,10Z"
                        transform="translate(-275.81831 -167.22456)" fill="#ccc" />
                    <path d="M528.18169,486.77544h-199a5,5,0,0,1,0-10h199a5,5,0,0,1,0,10Z"
                        transform="translate(-275.81831 -167.22456)" fill="#ccc" />
                    <path
                        d="M308.76592,350.30158l-4.10666-1.34461c-14.65756-4.94177-24.28705-8.09772-27.717-15.8291a12.03253,12.03253,0,0,1,5.83987-15.98312q.1583-.07357.31864-.14252a13.08862,13.08862,0,0,1,10.99658.23547,13.08814,13.08814,0,0,1,7.20517-8.31057A12.03257,12.03257,0,0,1,317.25,314.86374q.0726.1587.14056.31946c3.43,7.73144-.6926,16.98849-6.86548,31.17145Z"
                        transform="translate(-275.81831 -167.22456)" fill="#ff6584" />
                    <path
                        d="M516.74909,194.91069l-2.67726-.87659c-9.55571-3.22169-15.83347-5.27915-18.06956-10.31948a7.84438,7.84438,0,0,1,3.80719-10.41989q.1032-.048.20773-.09291a8.53285,8.53285,0,0,1,7.169.15352,8.53259,8.53259,0,0,1,4.69728-5.41792,7.8444,7.8444,0,0,1,10.39665,3.87026q.04733.10345.09163.20826c2.23612,5.04037-.45152,11.07532-4.47581,20.32162Z"
                        transform="translate(-275.81831 -167.22456)" fill="#ff6584" />
                    <path
                        d="M599.18169,273.77544h-77a9.01031,9.01031,0,0,1-9-9v-49a9.01031,9.01031,0,0,1,9-9h77a9.01032,9.01032,0,0,1,9,9v49A9.01032,9.01032,0,0,1,599.18169,273.77544Zm-77-65a7.00786,7.00786,0,0,0-7,7v49a7.00786,7.00786,0,0,0,7,7h77a7.00787,7.00787,0,0,0,7-7v-49a7.00787,7.00787,0,0,0-7-7Z"
                        transform="translate(-275.81831 -167.22456)" fill="#3f3d56" />
                    <path
                        d="M560.26909,239.83257a10.04027,10.04027,0,0,1-5.75562-1.80029l-38.63708-27.01319,1.146-1.63867,38.63709,27.01318a8.0889,8.0889,0,0,0,9.11255.07129l39.77453-26.89062,1.12012,1.65723-39.77453,26.89062A10.0393,10.0393,0,0,1,560.26909,239.83257Z"
                        transform="translate(-275.81831 -167.22456)" fill="#3f3d56" />
                    <circle cx="284.36337" cy="72.55088" r="12" fill="#3f3d56" />
                    <path
                        d="M851.3026,279.91393l-2.134-.69871c-7.61667-2.56794-12.62054-4.2079-14.40289-8.22545a6.2526,6.2526,0,0,1,3.03463-8.30548q.08226-.03822.16558-.07406a6.80136,6.80136,0,0,1,5.71427.12237,6.80118,6.80118,0,0,1,3.7441-4.31852,6.25262,6.25262,0,0,1,8.287,3.08491q.03772.08247.073.166c1.78236,4.01758-.35991,8.82792-3.56759,16.198Z"
                        transform="translate(-275.81831 -167.22456)" fill="#ff6584" />
                    <path
                        d="M917.008,342.77544H855.63282a7.18194,7.18194,0,0,1-7.17372-7.17372V296.54481a7.18194,7.18194,0,0,1,7.17372-7.17372H917.008a7.18194,7.18194,0,0,1,7.17372,7.17372v39.05691A7.18194,7.18194,0,0,1,917.008,342.77544Zm-61.37515-51.81019a5.58583,5.58583,0,0,0-5.57956,5.57956v39.05691a5.58583,5.58583,0,0,0,5.57956,5.57956H917.008a5.58583,5.58583,0,0,0,5.57956-5.57956V296.54481a5.58583,5.58583,0,0,0-5.57956-5.57956Z"
                        transform="translate(-275.81831 -167.22456)" fill="#3f3d56" />
                    <path
                        d="M885.99152,315.72026a8.00285,8.00285,0,0,1-4.58769-1.435L850.607,292.75362l.91345-1.30615,30.79684,21.53166a6.44751,6.44751,0,0,0,7.26343.05682l31.70349-21.434.89282,1.32094-31.70348,21.434A8.00215,8.00215,0,0,1,885.99152,315.72026Z"
                        transform="translate(-275.81831 -167.22456)" fill="#3f3d56" />
                    <circle cx="610.10354" cy="148.45017" r="9.56496" fill="#3f3d56" />
                    <path d="M907.18169,732.77544h-381a1,1,0,0,1,0-2h381a1,1,0,0,1,0,2Z"
                        transform="translate(-275.81831 -167.22456)" fill="#3f3d56" />
                </svg>
            </div>
            <h4>{{ translate('You do not have any support tickets') }}</h4>
            <p class="mb-0">
                {{ translate('You do not have any support tickets, when you have tickets with our support you will see them here.') }}
            </p>
        </div>
    @endif
@endsection
