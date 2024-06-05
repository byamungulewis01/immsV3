@can('read airport')
    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Inboxing </span></li>
    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarUI" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="sidebarUI">
            <i class="ri-bell-line"></i><span data-key="t-base-ui">Receive Dispatch</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.inbox.AirportDispach',
            'admin.inbox.DispatchTransfered',
            'admin.inbox.Mailarrived',
        ])
            ? 'show'
            : '' }}"
            id="sidebarUI">
            <div class="row">
                <div class="col-lg-4">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="{{ route('admin.inbox.AirportDispach') }}"
                                class="nav-link {{ Request::routeIs('admin.inbox.AirportDispach') ? 'active' : '' }}"
                                data-key="t-alerts">Dispatch List </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.inbox.DispatchTransfered') }}"
                                class="nav-link {{ Request::routeIs('admin.inbox.DispatchTransfered') ? 'active' : '' }}"
                                data-key="t-badges">Dispatch Transfered</a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="{{ route('admin.inbox.Mailarrived') }}"
                                class="nav-link {{ Request::routeIs('admin.inbox.Mailarrived') ? 'active' : '' }}"
                                data-key="t-badges">Dispatch
                                Arrived</a>
                        </li> --}}

                    </ul>
                </div>
            </div>
        </div>
    </li>
@endcan

@can('read incoming mail')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarTables" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="sidebarTables">
            <i class="ri-file-word-line"></i> <span data-key="t-tables">Dispatch Inboxing</span>
        </a>
        <div class="collapse menu-dropdown {{ Request::routeIs([
            'admin.cntp.CntpDispach',
            'admin.cntp.CntpMailOpening',
            'admin.cntp.CntpemsOpening',
            'admin.cntp.CntppercelOpening',
            'admin.cntp.CntpregOpening',
            'admin.cntpsort.Cntpallmailssorting',
            'admin.cntpsort.Cntpregisteredsorting',
            'admin.cntpsort.Cntppercelsorting',
            'admin.cntpsort.CntpEmssorting',
            'admin.cntpsort.sortingemsview',
            'admin.cntpsort.sortingpercelview',
            'admin.cntpsort.sortingregisteredview',
            'admin.cntpsort.sortingallmailsview',
        ])
            ? 'show'
            : '' }}"
            id="sidebarTables">
            <ul class="nav nav-sm flex-column">

                <li class="nav-item">
                    <a href="{{ route('admin.cntp.CntpDispach') }}"
                        class="nav-link {{ Request::routeIs('admin.cntp.CntpDispach') ? 'active' : '' }}"
                        data-key="t-basic-tables">Dispacher
                        Recieving</a>
                </li>
                @if (auth()->user()->level === 'cntp' && auth()->user()->cntpoffice == 'cntpoffice')
                    <li class="nav-item">
                        <a href="{{ route('admin.cntp.CntpMailOpening') }}"
                            class="nav-link {{ Request::routeIs('admin.cntp.CntpMailOpening') ? 'active' : '' }}"
                            data-key="t-grid-js">Dispacher
                            Opening</a>
                    </li>
                @endif
                @if (auth()->user()->cntpoffice == 'emscntp')
                    <li class="nav-item">
                        <a href="{{ route('admin.cntp.CntpemsOpening') }}"
                            class="nav-link {{ Request::routeIs('admin.cntp.CntpemsOpening') ? 'active' : '' }}"
                            data-key="t-grid-js">Dispacher
                            Opening</a>
                    </li>
                @endif
                @if (auth()->user()->cntpoffice == 'perceloffice')
                    <li class="nav-item">
                        <a href="{{ route('admin.cntp.CntppercelOpening') }}"
                            class="nav-link {{ Request::routeIs(['admin.cntp.CntppercelOpening']) ? 'active' : '' }}"
                            data-key="t-grid-js">Dispacher Opening</a>
                    </li>
                @endif
                @if (auth()->user()->cntpoffice == 'boxoffice')
                    <li class="nav-item">
                        <a href="{{ route('admin.cntp.CntpregOpening') }}"
                            class="nav-link {{ Request::routeIs(['admin.cntp.CntpregOpening']) ? 'active' : '' }}"
                            data-key="t-grid-js">Dispacher
                            Opening</a>
                    </li>
                @endif
                @if (auth()->user()->cntpoffice == 'emscntp')
                    <li class="nav-item">
                        <a href="{{ route('admin.cntpsort.CntpEmssorting') }}"
                            class="nav-link {{ Request::routeIs(['admin.cntpsort.CntpEmssorting', 'admin.cntpsort.sortingemsview']) ? 'active' : '' }}"
                            data-key="t-grid-js">Dispacher Sorting</a>
                    </li>
                @endif
                @if (auth()->user()->cntpoffice == 'perceloffice')
                    <li class="nav-item">
                        <a href="{{ route('admin.cntpsort.Cntppercelsorting') }}"
                            class="nav-link {{ Request::routeIs(['admin.cntpsort.Cntppercelsorting', 'admin.cntpsort.sortingpercelview']) ? 'active' : '' }}"
                            data-key="t-grid-js">Dispacher Sorting</a>
                    </li>
                @endif
                @if (auth()->user()->cntpoffice == 'boxoffice')
                    <li class="nav-item">
                        <a href="{{ route('admin.cntpsort.Cntpregisteredsorting') }}"
                            class="nav-link {{ Request::routeIs(['admin.cntpsort.Cntpregisteredsorting', 'admin.cntpsort.sortingregisteredview']) ? 'active' : '' }}"
                            data-key="t-grid-js">Dispacher Sorting</a>
                    </li>
                @endif
                @if (auth()->user()->level === 'cntp' && auth()->user()->cntpoffice == 'cntpoffice')
                    <li class="nav-item">
                        <a href="{{ route('admin.cntpsort.Cntpallmailssorting') }}"
                            class="nav-link {{ Request::routeIs(['admin.cntpsort.Cntpallmailssorting', 'admin.cntpsort.sortingallmailsview']) ? 'active' : '' }}"
                            data-key="t-grid-js">Dispacher Sorting</a>
                    </li>
                @endif

            </ul>
        </div>
    </li>
@endcan



@can('read incoming mail')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarIcons" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="sidebarIcons">
            <i class="ri-compasses-2-line"></i> <span data-key="t-icons">Mail Registration</span>
        </a>
        <div class="collapse menu-dropdown
        {{ in_array(Route::currentRouteName(), [
            'admin.mails.OrdinaryMail',
            'admin.mails.Ordregistration',
            'admin.transfero.OrdinaryMailTransfer',
            'admin.transfero.OrdinaryMailTransfers',
            'admin.mailsprinted.PrintedMaterial',
            'admin.mailsprinted.PrintedMaterialreg',
            'admin.transferprinted.PrintedMaterialTransfer',
            'admin.transferprinted.PrintedMaterialTransfers',
            'admin.mailsjurnal.Jurnal',
            'admin.mailsjurnal.Jurnalreg',
            'admin.transferjurnal.JurnalTransfer',
            'admin.transferjurnal.JurnalTransfers',
            'admin.mailsgooglead.Googlead',
            'admin.transfergooglead.GoogleadTransfer',
            'admin.mailspostcard.PostCard',
            'admin.transferpostcard.PostCardTransfer',
            'admin.transferpostcard.PostCardTransfers',
            'admin.mailsr.RegisteredMail',
            'admin.mailsr.registration',
            'admin.transferr.RegisteredMailTransfer',
            'admin.transferr.RegisteredMailTransfers',
            'admin.mailsp.PercelMail',
            'admin.mailspostcard.PostCardreg',
            'admin.transferp.PercelMailTransfer',
            'admin.transferp.PercelMailTransfers',
            'admin.mailsem.EmsMail',
            'admin.transferem.EmsMailTransfer',
            'admin.transferem.EmsMailTransfers',
            'admin.mailsp.PercelMails',
            'admin.mailsem.EmsMails',
        ])
            ? 'show'
            : '' }}"
            id="sidebarIcons">
            <ul class="nav nav-sm flex-column">
                @if (auth()->user()->level === 'cntp' && auth()->user()->cntpoffice == 'cntpoffice')
                    <li class="nav-item">
                        <a href="{{ route('admin.mails.OrdinaryMail') }}"
                            class="nav-link {{ Request::routeIs(['admin.mails.OrdinaryMail', 'admin.mails.Ordregistration']) ? 'active' : '' }}"
                            data-key="t-remix">Ordinary
                            Mail</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.transfero.OrdinaryMailTransfer') }}"
                            class="nav-link {{ Request::routeIs(['admin.transfero.OrdinaryMailTransfer', 'admin.transfero.OrdinaryMailTransfers']) ? 'active' : '' }}"
                            data-key="t-remix">Ordinary Mail Transfer</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.mailsprinted.PrintedMaterial') }}"
                            class="nav-link {{ Request::routeIs(['admin.mailsprinted.PrintedMaterial', 'admin.mailsprinted.PrintedMaterialreg']) ? 'active' : '' }}"
                            data-key="t-remix">Printed Material</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.transferprinted.PrintedMaterialTransfer') }}"
                            class="nav-link {{ Request::routeIs(['admin.transferprinted.PrintedMaterialTransfer', 'admin.transferprinted.PrintedMaterialTransfers']) ? 'active' : '' }}"
                            data-key="t-remix">Printed Material Transfer</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.mailsjurnal.Jurnal') }}"
                            class="nav-link {{ Request::routeIs(['admin.mailsjurnal.Jurnal', 'admin.mailsjurnal.Jurnalreg']) ? 'active' : '' }}"
                            data-key="t-remix">Jurnal</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.transferjurnal.JurnalTransfer') }}"
                            class="nav-link {{ Request::routeIs(['admin.transferjurnal.JurnalTransfer', 'admin.transferjurnal.JurnalTransfers']) ? 'active' : '' }}"
                            data-key="t-remix">Jurnal Transfer</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.mailsgooglead.Googlead') }}"
                            class="nav-link {{ Request::routeIs('admin.mailsgooglead.Googlead') ? 'active' : '' }}"
                            data-key="t-remix">Google
                            Adjacent</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.transfergooglead.GoogleadTransfer') }}"
                            class="nav-link {{ Request::routeIs('admin.transfergooglead.GoogleadTransfer') ? 'active' : '' }}"
                            data-key="t-remix">Google Adjacent Transfer</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.mailspostcard.PostCard') }}"
                            class="nav-link {{ Request::routeIs(['admin.mailspostcard.PostCard', 'admin.mailspostcard.PostCardreg']) ? 'active' : '' }}"
                            data-key="t-remix">Post
                            Card</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.transferpostcard.PostCardTransfer') }}"
                            class="nav-link {{ Request::routeIs(['admin.transferpostcard.PostCardTransfer', 'admin.transferpostcard.PostCardTransfers']) ? 'active' : '' }}"
                            data-key="t-remix">Post Card Transfer</a>
                    </li>
                @endif

                @if (auth()->user()->cntpoffice == 'boxoffice')
                    <li class="nav-item">
                        <a href="{{ route('admin.mailsr.RegisteredMail') }}"
                            class="nav-link {{ Request::routeIs(['admin.mailsr.RegisteredMail', 'admin.mailsr.registration']) ? 'active' : '' }}"
                            data-key="t-boxicons">Registered Mail</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.transferr.RegisteredMailTransfer') }}"
                            class="nav-link {{ Request::routeIs(['admin.transferr.RegisteredMailTransfer', 'admin.transferr.RegisteredMailTransfers']) ? 'active' : '' }}"
                            data-key="t-boxicons">Registered Mail Transfer</a>
                    </li>
                @endif
                @if (auth()->user()->cntpoffice == 'perceloffice')
                    <li class="nav-item">
                        <a href="{{ route('admin.mailsp.PercelMail') }}"
                            class="nav-link {{ Request::routeIs(['admin.mailsp.PercelMail', 'admin.mailsp.PercelMails']) ? 'active' : '' }}">
                            <span data-key="t-crypto-svg">Parcel MAIL</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.transferp.PercelMailTransfer') }}"
                            class="nav-link {{ Request::routeIs(['admin.transferp.PercelMailTransfer', 'admin.transferp.PercelMailTransfers']) ? 'active' : '' }}">
                            <span data-key="t-crypto-svg">Parcel Mail Transfer</span></a>
                    </li>
                @endif
                @if (auth()->user()->cntpoffice == 'emscntp')
                    <li class="nav-item">
                        <a href="{{ route('admin.mailsem.EmsMail') }}"
                            class="nav-link {{ Request::routeIs(['admin.mailsem.EmsMail', 'admin.mailsem.EmsMails']) ? 'active' : '' }}">
                            <span data-key="t-crypto-svg">EMS MAIL</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.transferem.EmsMailTransfer') }}"
                            class="nav-link {{ Request::routeIs(['admin.transferem.EmsMailTransfer', 'admin.transferem.EmsMailTransfers']) ? 'active' : '' }}">
                            <span data-key="t-crypto-svg">EMS MAIL Transfer</span></a>
                    </li>
                @endif

            </ul>
        </div>
    </li>
@endcan
@can('read incoming mail')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarIconss" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="sidebarIcons">
            <i class="ri-mail-line"></i> <span data-key="t-icons">Letter Registration</span>
        </a>
        <div class="collapse menu-dropdown" id="sidebarIconss">
            <ul class="nav nav-sm flex-column">

                @if (auth()->user()->level === 'cntp' && auth()->user()->cntpoffice == 'cntpoffice')
                    <li class="nav-item">
                        <a href="{{ route('admin.mailsrl.RegisteredLetter') }}" class="nav-link"> <span
                                data-key="t-crypto-svg">Registered Letter</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.transferrl.RegisteredLetterTransfer') }}" class="nav-link"> <span
                                data-key="t-crypto-svg">Registered Letter Transfer</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.mailsol.OrdinaryLetter') }}" class="nav-link"> <span
                                data-key="t-crypto-svg">Ordinary Letter</span></a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.transferol.OrdinaryLetterTransfer') }}" class="nav-link"> <span
                                data-key="t-crypto-svg">Ordinary Letter Transfer</span></a>
                    </li>
                @endif


            </ul>
        </div>
    </li>
@endcan
@can('read airport')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarU" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="sidebarUI">
            <i class="ri-pencil-ruler-2-line"></i> <span data-key="t-base-ui">Dispatch Report</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.inbox.AirportDispachrepd',
            'admin.inbox.AirportDispachrep',
            'admin.inbox.AirportDispachrepd_orgin',
        ])
            ? 'show'
            : '' }}"
            id="sidebarU">
            <div class="row">
                <div class="col-lg-4">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="{{ route('admin.inbox.AirportDispachrepd') }}"
                                class="nav-link {{ Request::routeIs(['admin.inbox.AirportDispachrepd', 'admin.inbox.AirportDispachrepd_orgin']) ? 'active' : '' }}"
                                data-key="t-alerts">Daily Report</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.inbox.AirportDispachrep') }}"
                                class="nav-link {{ Request::routeIs('admin.inbox.AirportDispachrep') ? 'active' : '' }}"
                                data-key="t-badges">Monthly Report</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </li>
@endcan

@can('read incoming mail')
    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Outboxing </span></li>

    <li class="nav-item">
        <a class="nav-link menu-link" href="#ctnptoutboxing" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="sidebarTables">
            <i class="ri-layout-grid-line"></i> <span data-key="t-tables">Dispatch Outboxing</span>
        </a>
        <div class="collapse menu-dropdown" id="ctnptoutboxing">
            <ul class="nav nav-sm flex-column">

                <li class="nav-item">
                    <a href="{{ route('admin.outtems.outboxingems') }}" class="nav-link" data-key="t-basic-tables">EMS
                        Receiving</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.outtregis.outboxingregistered') }}" class="nav-link"
                        data-key="t-grid-js">Registered Receiving</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.outtperc.outboxingpercel') }}" class="nav-link" data-key="t-grid-js">Parcel
                        Receiving</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.outttem.outboxingtemble') }}" class="nav-link" data-key="t-grid-js">Posting
                        With Temble</a>
                </li> --}}
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link menu-link" href="#ctnptoutboxingreport" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="sidebarTables">
            <i class="ri-cloudy-line"></i> <span data-key="t-tables">Outboxing Report</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['admin.cntp.reportDispachDaily', 'admin.cntp.reportDispatchmonthly'])
            ? 'show'
            : '' }}"
            id="ctnptoutboxingreport">
            <ul class="nav nav-sm flex-column">

                <li class="nav-item">
                    <a href="{{ route('admin.cntp.reportDispachDaily') }}"
                        class="nav-link {{ Request::routeIs('admin.cntp.reportDispachDaily') ? 'active' : '' }}"
                        data-key="t-basic-tables">Daily Opening</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.cntp.reportDispatchmonthly') }}"
                        class="nav-link {{ Request::routeIs('admin.cntp.reportDispatchmonthly') ? 'active' : '' }}"
                        data-key="t-grid-js">Monthly Opening</a>
                </li>
                <li class="nav-item ">
                    <a href="#employees" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="employees" data-key="t-candidate-lists">
                        Dispatch Outboxing
                    </a>
                    <div class="collapse menu-dropdown " id="employees">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.outtems.reportoutboxingems') }}" class="nav-link"
                                    data-key="t-all">EMS
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.outtregis.detailsregistered') }}" class="nav-link "
                                    data-key="t-active">Registered Small Packet
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.outtperc.perceloutboxingregise') }}" class="nav-link"
                                    data-key="t-inactive">Parcel
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.outttem.tembleoutboxingrep') }}" class="nav-link"
                                    data-key="t-deactiveted">Post With Temble
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.combined.index') }}" class="nav-link" data-key="t-starter">Packing
                        Outboxing</a>
                </li>


            </ul>
        </div>
    </li>
@endcan



{{-- start branch manager activity --}}
@can('Read Dispach Recieving')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="sidebarLanding">
            <i class="ri-rocket-line"></i> <span data-key="t-landing">Mail Inboxing</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.dreceive.Depechereceive',
            'admin.mrcsn.Mailcheckingandnotification',
            'admin.mrcsn.rcsnotification',
            'admin.list.search',
            'admin.pay.Omailpay',
            'admin.payr.Rmailpay',
            'admin.emspay.emspays',
            'admin.payg.Googlepay',
            'admin.payp.Pmailpay',
            'admin.mailde.Maildelevery',
            'admin.mailde.reports',
        ])
            ? 'show'
            : '' }}"
            id="sidebarLanding">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dreceive.Depechereceive') }}"
                        class="nav-link {{ Request::routeIs('admin.dreceive.Depechereceive') ? 'active' : '' }}"
                        data-key="t-one-page">Dispach Receiving</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.mrcsn.Mailcheckingandnotification') }}"
                        class="nav-link {{ Request::routeIs(['admin.mrcsn.Mailcheckingandnotification', 'admin.mrcsn.rcsnotification']) ? 'active' : '' }}"
                        data-key="t-nft-landing">Mail RCSN</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.list.search') }}"
                        class="nav-link {{ Request::routeIs('admin.list.search') ? 'active' : '' }}"
                        data-key="t-nft-landing">Mail Tracking</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pay.Omailpay') }}"
                        class="nav-link {{ Request::routeIs('admin.pay.Omailpay') ? 'active' : '' }}"
                        data-key="t-nft-landing">Ordinary
                        Pay</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.payr.Rmailpay') }}"
                        class="nav-link {{ Request::routeIs('admin.payr.Rmailpay') ? 'active' : '' }}"
                        data-key="t-nft-landing">Registered
                        Pay</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.payp.Pmailpay') }}"
                        class="nav-link {{ Request::routeIs('admin.payp.Pmailpay') ? 'active' : '' }}"
                        data-key="t-nft-landing">Parcel
                        Pay</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.emspay.emspays') }}"
                        class="nav-link {{ Request::routeIs('admin.emspay.emspays') ? 'active' : '' }}"
                        data-key="t-nft-landing">EMS Pay</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.payg.Googlepay') }}" class="nav-link {{ Request::routeIs('admin.payg.Googlepay') ? 'active' : '' }}" data-key="t-nft-landing">Google Ad
                        Pay</a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('admin.mailde.Maildelevery') }}"
                        class="nav-link {{ Request::routeIs('admin.mailde.Maildelevery') ? 'active' : '' }}"
                        data-key="t-nft-landing">Mail
                        Delivery</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.mailde.reports') }}"
                        class="nav-link {{ Request::routeIs('admin.mailde.reports') ? 'active' : '' }}"
                        data-key="t-nft-landing">Mail
                        Reports</a>
                </li>
            </ul>
        </div>
    </li>
@endcan

{{--  <li class="nav-item">
              <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                  <i class="ri-rocket-line"></i> <span data-key="t-landing">Income Registration</span>
              </a>
              <div class="collapse menu-dropdown" id="sidebarLanding">
                  <ul class="nav nav-sm flex-column">
                      <li class="nav-item">
                          <a href="{{ route('admin.income.Oincames') }}" class="nav-link" data-key="t-one-page">Ordinary Incomes</a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('admin.incomer.Rincames') }}" class="nav-link" data-key="t-nft-landing">Registered Incomes</a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('admin.incomep.Pincames') }}" class="nav-link" data-key="t-nft-landing">Percel Incomes</a>
                      </li>
                  </ul>
              </div>
          </li>
          @endcan
        --}}


{{-- <li class="nav-item">
        <a class="nav-link menu-link {{ in_array(Route::currentRouteName(), ['branch.outboxing.create', 'branch.outboxing.list', 'branch.outboxing.edit']) ? 'active' : '' }}"
            href="{{ route('branch.outboxing.list') }}" role="button" aria-expanded="false"
            aria-controls="outboxingmanagement">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Mail Outboxing</span>
        </a> --}}
{{-- <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['branch.outboxing.create', 'branch.outboxing.list' ,'branch.outboxing.edit']) ? 'show' : '' }}"
            id="outboxingmanagement">
            <ul class="nav nav-sm flex-column">
                @can('make outboxing') --}}
{{-- <li class="nav-item">
                        <a href="{{ route('branch.outboxing.index') }}" class="nav-link" data-key="t-starter">EMS</a>
                    </li> --}}
{{-- <li class="nav-item">
                        <a href="{{ route('branch.outboxing.create') }}"
                            class="nav-link {{ in_array(Route::currentRouteName(), ['branch.outboxing.create']) ? 'active' : '' }}"
                            data-key="t-create">Create</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('branch.outboxing.list') }}"
                            class="nav-link {{ in_array(Route::currentRouteName(), ['branch.outboxing.list']) ? 'active' : '' }}"
                            data-key="t-list">List</a>
                    </li>
                @endcan --}}
{{-- @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.registeredoutboxing.index') }}" class="nav-link"
                            data-key="t-starter">Registered & Small Packet </a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.perceloutboxing.index') }}" class="nav-link" data-key="t-starter">Percel
                        </a>
                    </li>
                @endcan --}}
{{-- @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.tembleoutboxing.index') }}" class="nav-link" data-key="t-starter">Posting
                            With Temble</a>
                    </li>
                @endcan --}}

{{-- </ul>
        </div> --}}
{{-- </li> --}}

@can('read outboxing')
    <li class="nav-item">
        <a class="nav-link menu-link {{ in_array(Route::currentRouteName(), ['branch.outboxing.create', 'branch.outboxing.list', 'branch.outboxing.edit', 'branch.outboxing.tranfered']) ? 'active' : '' }}"
            href="#outboxingMail" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="outboxingMail">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Mail Outboxing</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['branch.outboxing.create', 'branch.outboxing.list', 'branch.outboxing.edit', 'branch.outboxing.tranfered']) ? 'show' : '' }}"
            id="outboxingMail">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('branch.outboxing.list') }}"
                        class="nav-link {{ in_array(Route::currentRouteName(), ['branch.outboxing.create', 'branch.outboxing.list', 'branch.outboxing.edit']) ? 'active' : '' }}"
                        data-key="t-ems">Create Mail</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('branch.outboxing.tranfered') }}"
                        class="nav-link {{ in_array(Route::currentRouteName(), ['branch.outboxing.tranfered']) ? 'active' : '' }}"
                        data-key="t-registerd">Transfered Mails </a>
                </li>
            </ul>
        </div>
    </li>
@endcan



@can('read outboxing')
    <li class="nav-item">
        <a class="nav-link menu-link {{ in_array(Route::currentRouteName(), ['admin.outte.ems', 'admin.outte.registerd', 'admin.outte.percel']) ? 'active' : '' }}"
            href="#outboxingtransfer" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="outboxingmanagement">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Mail Outboxing Transfer</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['admin.outte.ems', 'admin.outte.registerd', 'admin.outte.percel']) ? 'show' : '' }}"
            id="outboxingtransfer">
            <ul class="nav nav-sm flex-column">
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('admin.outte.ems') }}"
                            class="nav-link {{ in_array(Route::currentRouteName(), ['admin.outte.ems']) ? 'active' : '' }}"
                            data-key="t-ems">EMS </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.outte.registerd') }}"
                            class="nav-link {{ in_array(Route::currentRouteName(), ['admin.outte.registerd']) ? 'active' : '' }}"
                            data-key="t-registerd">Registered Small </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.outte.percel') }}"
                            class="nav-link {{ in_array(Route::currentRouteName(), ['admin.outte.percel']) ? 'active' : '' }}"
                            data-key="t-percel">Parcel </a>
                    </li>
                @endcan

                {{-- @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('admin.outtte.index') }}" class="nav-link" data-key="t-starter">Posting With
                            Temble</a>
                    </li>
                @endcan --}}

            </ul>
        </div>
    </li>
@endcan
{{--  @can('read outboxing')
        <li class="nav-item">
            <a class="nav-link menu-link" href="#mailincomehistory" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="mailincomehistory">
                <i class="ri-pages-line"></i> <span data-key="t-pages">Mail Income History</span>
            </a>
            <div class="collapse menu-dropdown" id="mailincomehistory">
                <ul class="nav nav-sm flex-column">
                    @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.outboxing.history') }}" class="nav-link" data-key="t-starter">EMS Mail Outboxing History</a>
                    </li>
                    @endcan
                    @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.registeredoutboxing.history') }}" class="nav-link" data-key="t-starter">Registered Small Packet Outboxing History</a>
                    </li>
                    @endcan
                    @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.perceloutboxing.history') }}" class="nav-link" data-key="t-starter">Percel Outboxing History</a>
                    </li>
                    @endcan
                    @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.tembleoutboxing.history') }}" class="nav-link" data-key="t-starter">Posting With Temble History</a>
                    </li>
                    @endcan

                </ul>
            </div>
        </li>
        @endcan
    --}}

@can('branch physicalPob')
    <li class="nav-item">
        <a class="nav-link menu-link {{ in_array(Route::currentRouteName(), ['physicalPob.index', 'physicalPob.waitingList', 'physicalPob.approved', 'physicalPob.details', 'physicalPob.pobCategory']) ? 'active' : '' }}"
            href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="sidebarLayouts">
            <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Physical P.O Box</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['physicalPob.index', 'physicalPob.waitingList', 'physicalPob.approved', 'physicalPob.selling', 'physicalPob.details', 'physicalPob.dailyIncome', 'physicalPob.monthlyIncome', 'physicalPob.pobCategory']) ? 'show' : '' }}"
            id="sidebarLayouts">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('physicalPob.index') }}"
                        class="nav-link {{ Request::routeIs('physicalPob.index') ? 'active' : '' }}"
                        data-key="t-poboxlist">P.O Box List</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('physicalPob.selling') }}"
                        class="nav-link {{ Request::routeIs('physicalPob.selling') ? 'active' : '' }}"
                        data-key="t-poboxSelling">P.O Box Selling</a>
                </li>
                <li class="nav-item">
                    <a href="#sidebarCandidatelists" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarCandidatelists" data-key="t-candidate-lists">
                        P.O Box Application
                    </a>
                    <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['physicalPob.waitingList', 'physicalPob.approved']) ? 'show' : '' }}"
                        id="sidebarCandidatelists">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('physicalPob.approved') }}"
                                    class="nav-link {{ Request::routeIs('physicalPob.approved') ? 'active' : '' }}"
                                    data-key="t-Approved"> Approved
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('physicalPob.waitingList') }}"
                                    class="nav-link {{ Request::routeIs('physicalPob.waitingList') ? 'active' : '' }}"
                                    data-key="t-Waiting-list"> Waiting list</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="{{ route('physicalPob.pobCategory') }}"
                        class="nav-link {{ Request::routeIs('physicalPob.pobCategory') ? 'active' : '' }}"
                        data-key="t-poboxSelling">P.O Box Categories</a>
                </li>
            </ul>
        </div>
    </li>
@endcan
@can('branch virtualPob')
    <li class="nav-item">
        <a class="nav-link menu-link {{ in_array(Route::currentRouteName(), ['virtualPob.index', 'virtualPob.waitingList', 'virtualPob.approved', 'virtualPob.details']) ? 'active' : '' }}"
            href="#virtualPob" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="virtualPob">
            <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Virtual P.O Box</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'virtualPob.index',
            'virtualPob.waitingList',
            'virtualPob.approved',
            'virtualPob.details',
            'virtualPob.dailyIncome',
            'virtualPob.monthlyIncome',
        ])
            ? 'show'
            : '' }}"
            id="virtualPob">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('virtualPob.index') }}"
                        class="nav-link {{ Request::routeIs('virtualPob.index') ? 'active' : '' }}"
                        data-key="t-virtual">P.O Box List</a>
                </li>

                <li class="nav-item">
                    <a href="#sidebarCandidatelists" class="nav-link" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarCandidatelists" data-key="t-candidate-lists">
                        P.O Box Application
                    </a>
                    <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['virtualPob.waitingList', 'virtualPob.approved']) ? 'show' : '' }}"
                        id="sidebarCandidatelists">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('virtualPob.approved') }}"
                                    class="nav-link {{ Request::routeIs('virtualPob.approved') ? 'active' : '' }}"
                                    data-key="t-Approved"> Approved
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('virtualPob.waitingList') }}"
                                    class="nav-link {{ Request::routeIs('virtualPob.waitingList') ? 'active' : '' }}"
                                    data-key="t-Waiting-list"> Waiting list</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </li>
@endcan
@can('read mails', 'read ems')
    <li class="nav-item">
        <a class="nav-link menu-link " href="#nationalMail" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="nationalMail">
            <i class="bx bx-cart fs-22"></i> <span data-key="t-nationalMail">EMS National</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['receiveDispatch.index', 'receiveDispatch.confirmed', 'receiveDispatch.show']) ? 'show' : '' }}"
            id="nationalMail">
            <ul class="nav nav-sm flex-column">
                {{-- view dispatch --}}
                <li class="nav-item">
                    <a href="{{ route('receiveDispatch.index') }}"
                        class="nav-link {{ Request::routeIs('receiveDispatch.index') ? 'active' : '' }}"
                        data-key="t-timeline"> View Dispatch </a>
                </li>
                {{-- Sent dispatch --}}
                <li class="nav-item">
                    <a href="{{ route('receiveDispatch.confirmed') }}"
                        class="nav-link {{ Request::routeIs('receiveDispatch.confirmed') ? 'active' : '' }}"
                        data-key="t-timeline"> Dispatch Confirmed </a>
                </li>


            </ul>
        </div>
    </li>
@endcan

@can('Manage Tarif')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="sidebarPages">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Service && Customer</span>
        </a>
        <div class="collapse menu-dropdown" id="sidebarPages">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.serv.Service') }}" class="nav-link" data-key="t-starter">Service Type
                        Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.cust.Customers') }}" class="nav-link" data-key="t-starter">Customer
                        Registration</a>
                </li>

            </ul>
        </div>
    </li>
@endcan
@can('Manage Tarif')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarPagess" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="sidebarPages">
            <i class="ri-pages-line"></i> <span data-key="t-pages">EMS Tarif Registration</span>
        </a>
        <div class="collapse menu-dropdown" id="sidebarPagess">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.countri.Countries') }}" class="nav-link" data-key="t-starter">Country
                        Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.zone.Zones') }}" class="nav-link" data-key="t-starter">Zone
                        Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.range.ranges') }}" class="nav-link" data-key="t-starter">Weight Range
                        Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.czone.czoness') }}" class="nav-link" data-key="t-starter">Tarif
                        Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.tarif.zone') }}" class="nav-link" data-key="t-starter">Tarif View All
                        Zone</a>
                </li>

            </ul>
        </div>
    </li>
@endcan
@can('read income')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#seling_carte_postel" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="seling_carte_postel">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Revenue Registration</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'branch.sellingpostel.index',
            'branch.sellingpostel.create',
            'branch.sellingpostel.edit',
            'admin.income.index',
            'admin.income_types.index',
            'admin.income.history',
            'branch.sellingpostel.history',
            'branch.sellingpostel.report',
        ])
            ? 'show'
            : '' }}"
            id="seling_carte_postel">
            <ul class="nav nav-sm flex-column">
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.sellingpostel.index') }}"
                            class="nav-link {{ Request::routeIs(['branch.sellingpostel.index', 'branch.sellingpostel.create', 'branch.sellingpostel.edit']) ? 'active' : '' }}"
                            data-key="t-starter">Carte Postel</a>
                    </li>
                @endcan
                @can('read income')
                    <li class="nav-item">
                        <a href="{{ route('admin.income.index') }}"
                            class="nav-link {{ Request::routeIs('admin.income.index') ? 'active' : '' }}"
                            data-key="t-starter">Other Revenue</a>
                    </li>
                @endcan
                @can('create income types')
                    <li class="nav-item">
                        <a href="{{ route('admin.income_types.index') }}"
                            class="nav-link {{ Request::routeIs('admin.income_types.index') ? 'active' : '' }}"
                            data-key="t-starter">New Revenue Type</a>
                    </li>
                @endcan
                @can('create income')
                    <li class="nav-item">
                        <a href="{{ route('admin.income.history') }}"
                            class="nav-link {{ Request::routeIs('admin.income.history') ? 'active' : '' }}"
                            data-key="t-starter">Income History</a>
                    </li>
                @endcan
                {{--  @can('make outboxing')
              <li class="nav-item">
                  <a href="{{ route('branch.sellingpostel.history') }}" class="nav-link {{ Request::routeIs('branch.sellingpostel.history') ? 'active' : '' }}" data-key="t-starter">Sales History</a>
              </li>
              @endcan
              @can('make outboxing')
              <li class="nav-item">
                  <a href="{{ route('branch.sellingpostel.report') }}" class="nav-link {{ Request::routeIs('branch.sellingpostel.report') ? 'active' : '' }}" data-key="t-starter">Sales Report</a>
              </li>
              @endcan
            --}}
            </ul>
        </div>
    </li>
@endcan
@can('read expense')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#expense_types_management" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="expense_types_management">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Expense Registration</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.expense_types.index',
            'admin.expenses.index',
            'admin.expenses.history',
            'admin.expenses.approved',
            'admin.expenses.rejected',
        ])
            ? 'show'
            : '' }}"
            id="expense_types_management">
            <ul class="nav nav-sm flex-column">
                @can('create expense types')
                    <li class="nav-item">
                        <a href="{{ route('admin.expense_types.index') }}"
                            class="nav-link {{ Request::routeIs('admin.expense_types.index') ? 'active' : '' }}"
                            data-key="t-starter">New Expense Type</a>
                    </li>
                @endcan
                @can('read expense')
                    <li class="nav-item">
                        <a href="{{ route('admin.expenses.index') }}"
                            class="nav-link {{ Request::routeIs('admin.expenses.index') ? 'active' : '' }}"
                            data-key="t-starter">New Expense</a>
                    </li>
                @endcan
                {{-- @can('create expense')
              <li class="nav-item">
                  <a href="{{ route('admin.expenses.history') }}" class="nav-link {{ Request::routeIs('admin.expenses.history') ? 'active' : '' }}" data-key="t-starter">Expenses History</a>
              </li>
              @endcan
            --}}
                @can('read expense')
                    <li class="nav-item">
                        <a href="{{ route('admin.expenses.approved') }}"
                            class="nav-link {{ Request::routeIs('admin.expenses.approved') ? 'active' : '' }}"
                            data-key="t-starter">Expenses Approved </a>
                    </li>
                @endcan
                @can('read expense')
                    <li class="nav-item">
                        <a href="{{ route('admin.expenses.rejected') }}"
                            class="nav-link {{ Request::routeIs('admin.expenses.rejected') ? 'active' : '' }}"
                            data-key="t-starter">Expenses Rejected </a>
                    </li>
                @endcan

            </ul>
        </div>
    </li>
@endcan
@can('Manage orders')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#ordermanagement" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="ordermanagement">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Product Requests</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'branch.order.index',
            'branch.order.status',
            'branch.order.history',
            'branch.order.approved',
            'branch.order.rejected',
        ])
            ? 'show'
            : '' }}"
            id="ordermanagement">
            <ul class="nav nav-sm flex-column">
                @can('make branchorder')
                    <li class="nav-item">
                        <a href="{{ route('branch.order.index') }}"
                            class="nav-link {{ Request::routeIs('branch.order.index') ? 'active' : '' }}"
                            data-key="t-starter">Request Registraion</a>
                    </li>
                @endcan
                @can('make branchorder')
                    <li class="nav-item">
                        <a href="{{ route('branch.order.status') }}"
                            class="nav-link {{ Request::routeIs('branch.order.status') ? 'active' : '' }}"
                            data-key="t-starter">Store</a>
                    </li>
                @endcan
                @can('read branchorder')
                    <li class="nav-item">
                        <a href="{{ route('branch.order.history') }}"
                            class="nav-link {{ Request::routeIs('branch.order.history') ? 'active' : '' }}"
                            data-key="t-starter">Manage Request </a>
                    </li>
                @endcan

                @can('Approved History')
                    <li class="nav-item">
                        <a href="{{ route('branch.order.approved') }}"
                            class="nav-link {{ Request::routeIs('branch.order.approved') ? 'active' : '' }}"
                            data-key="t-starter">Order Approved</a>
                    </li>
                @endcan
                @can('Approved History')
                    <li class="nav-item">
                        <a href="{{ route('branch.order.rejected') }}"
                            class="nav-link {{ Request::routeIs('branch.order.rejected') ? 'active' : '' }}"
                            data-key="t-starter">Order Rejected</a>
                    </li>
                @endcan

            </ul>
        </div>
    </li>
@endcan
@can('make outboxing')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#mailincomereport" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="mailincomereport">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Revenue Daily Reporting</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.income.Oincames',
            'admin.incomer.Rincames',
            'admin.incomep.Pincames',
            'admin.incomeems.incomeemss',
            'admin.incomegoogle.Gincames',
            'branch.outboxing.report',
            'branch.registeredoutboxing.report',
            'branch.registeredoutboxing.report',
            'branch.perceloutboxing.report',
            'branch.tembleoutboxing.report',
            'physicalPob.dailyIncome',
            'virtualPob.dailyIncome',
            'admin.income.incomesreportbranch',
            'admin.income.Homedelireportbranch',
        ])
            ? 'show'
            : '' }}"
            id="mailincomereport">
            <ul class="nav nav-sm flex-column">

                <li class="nav-item">
                    <a href="{{ route('admin.income.Oincames') }}"
                        class="nav-link {{ Request::routeIs('admin.income.Oincames') ? 'active' : '' }}"
                        data-key="t-one-page">Ordinary Inbox</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.incomer.Rincames') }}"
                        class="nav-link {{ Request::routeIs('admin.incomer.Rincames') ? 'active' : '' }}"
                        data-key="t-nft-landing">Registered Inbox</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.incomep.Pincames') }}"
                        class="nav-link {{ Request::routeIs('admin.incomep.Pincames') ? 'active' : '' }}"
                        data-key="t-nft-landing">Parcel Inbox</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.incomeems.incomeemss') }}"
                        class="nav-link {{ Request::routeIs('admin.incomeems.incomeemss') ? 'active' : '' }}"
                        data-key="t-nft-landing">EMS Inbox</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.incomegoogle.Gincames') }}"
                        class="nav-link {{ Request::routeIs('admin.incomegoogle.Gincames') ? 'active' : '' }}"
                        data-key="t-nft-landing">Google Ad Inbox</a>
                </li> --}}

                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.registeredoutboxing.report') }}"
                            class="nav-link {{ Request::routeIs('branch.registeredoutboxing.report') ? 'active' : '' }}"
                            data-key="t-starter">Registered Small Packet Outbox</a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.perceloutboxing.report') }}"
                            class="nav-link {{ Request::routeIs('branch.perceloutboxing.report') ? 'active' : '' }}"
                            data-key="t-starter">Parcel Outbox</a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.outboxing.report') }}"
                            class="nav-link {{ Request::routeIs('branch.outboxing.report') ? 'active' : '' }}"
                            data-key="t-starter">EMS Outbox</a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.tembleoutboxing.report') }}"
                            class="nav-link {{ Request::routeIs('branch.tembleoutboxing.report') ? 'active' : '' }}"
                            data-key="t-starter">Stamps Outbox</a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('physicalPob.dailyIncome') }}"
                            class="nav-link {{ Request::routeIs('physicalPob.dailyIncome') ? 'active' : '' }}"
                            data-key="t-starter">Physical P.O Box</a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('virtualPob.dailyIncome') }}"
                            class="nav-link {{ Request::routeIs('virtualPob.dailyIncome') ? 'active' : '' }}"
                            data-key="t-starter">Virtual P.O Box</a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('admin.income.incomesreportbranch') }}"
                            class="nav-link {{ Request::routeIs('admin.income.incomesreportbranch') ? 'active' : '' }}"
                            data-key="t-starter">Other Revenue</a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('admin.income.Homedelireportbranch') }}"
                            class="nav-link {{ Request::routeIs('admin.income.Homedelireportbranch') ? 'active' : '' }}"
                            data-key="t-starter">Home Delivery</a>
                    </li>
                @endcan

            </ul>
        </div>
    </li>
@endcan

@can('read outboxing')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#agenciesreport" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="agenciesreport">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Branch Report</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'branch.breporting.daily',
            'branch.breporting.daily_details',
            'branch.breporting.monthly',
            'branch.breporting.expenses',
            'branch.breporting.profit',
            'branch.breporting.daily_expenses',
            'branch.breporting.daily_expenses_details',
            'branch.breporting.monthly_expenses',
            'branch.breporting.monthly_expenses_details',
        ])
            ? 'show'
            : '' }}"
            id="agenciesreport">
            <ul class="nav nav-sm flex-column">
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.breporting.daily') }}"
                            class="nav-link {{ Request::routeIs(['branch.breporting.daily', 'branch.breporting.daily_details']) ? 'active' : '' }}"
                            data-key="t-starter">Daily Income Agencies </a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.breporting.monthly') }}"
                            class="nav-link {{ Request::routeIs('branch.breporting.monthly') ? 'active' : '' }}"
                            data-key="t-starter">Monthly Income Agencies</a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.breporting.daily_expenses') }}"
                            class="nav-link {{ Request::routeIs(['branch.breporting.daily_expenses', 'branch.breporting.daily_expenses_details']) ? 'active' : '' }}"
                            data-key="t-starter">Daily Expenses Agencies</a>
                    </li>
                @endcan
                @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.breporting.monthly_expenses') }}"
                            class="nav-link {{ Request::routeIs(['branch.breporting.monthly_expenses', 'branch.breporting.monthly_expenses_details']) ? 'active' : '' }}"
                            data-key="t-starter">Monthly Expenses Agencies</a>
                    </li>
                @endcan
                {{-- @can('make outboxing')
                    <li class="nav-item">
                        <a href="{{ route('branch.breporting.profit') }}"
                            class="nav-link {{ Request::routeIs('branch.breporting.profit') ? 'active' : '' }}"
                            data-key="t-starter">Monthly (Income-Expense) Agencies</a>
                    </li>
                @endcan --}}

            </ul>
        </div>
    </li>
@endcan

@can('Manage Tarif')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarPagesss" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="sidebarPages">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Registered Small Packet</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.regcountries.countriesview',
            'admin.prange.pranges',
            'admin.rspatreg.rspatregs',
            'admin.tarif.continent',
        ])
            ? 'show'
            : '' }}"
            id="sidebarPagesss">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.regcountries.countriesview') }}"
                        class="nav-link {{ Request::routeIs('admin.regcountries.countriesview') ? 'active' : '' }}"
                        data-key="t-starter">Country Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.prange.pranges') }}"
                        class="nav-link {{ Request::routeIs('admin.prange.pranges') ? 'active' : '' }}"
                        data-key="t-starter">Weight Range Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.rspatreg.rspatregs') }}"
                        class="nav-link {{ Request::routeIs('admin.rspatreg.rspatregs') ? 'active' : '' }}"
                        data-key="t-starter">Tarif Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.tarif.continent') }}"
                        class="nav-link {{ Request::routeIs('admin.tarif.continent') ? 'active' : '' }}"
                        data-key="t-starter">Small Packet Tarif View</a>
                </li>

            </ul>
        </div>
    </li>
@endcan
@can('Manage Tarif')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarPagessss" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="sidebarPages">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Parcel Tarif Registration</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.percecountreg.percecountregs',
            'admin.pweight.pweights',
            'admin.perceltreg.perceltregs',
            'admin.tarif.country',
        ])
            ? 'show'
            : '' }}"
            id="sidebarPagessss">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.percecountreg.percecountregs') }}"
                        class="nav-link {{ Request::routeIs('admin.percecountreg.percecountregs') ? 'active' : '' }}"
                        data-key="t-starter">Country Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pweight.pweights') }}"
                        class="nav-link {{ Request::routeIs('admin.pweight.pweights') ? 'active' : '' }}"
                        data-key="t-starter">Weight Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.perceltreg.perceltregs') }}"
                        class="nav-link {{ Request::routeIs('admin.perceltreg.perceltregs') ? 'active' : '' }}"
                        data-key="t-starter">Tarif Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.tarif.country') }}"
                        class="nav-link {{ Request::routeIs('admin.tarif.country') ? 'active' : '' }}"
                        data-key="t-starter">Parcel Tarif View</a>
                </li>

            </ul>
        </div>
    </li>
@endcan

{{-- can read Category --}}

{{-- @can('read category')
    <li class="nav-item">
        <a class="nav-link menu-link {{ Request::routeIs('admin.comments.comment') ? 'active' : '' }}"
            href="{{ route('admin.comments.Comment') }}">
            <i class="ri-keyboard-box-line"></i> <span data-key="t-base-hu">Comment Registration</span>
        </a>

    </li>
@endcan --}}
{{-- can read Category --}}

@can('read purchase')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#purchase_management" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="purchase_management">
            <i class="ri-apps-2-line"></i><span data-key="t-pages">Product Management</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.purchase.index',
            'admin.purchase.view',
            'admin.purchase.list',
            'admin.purchase.report',
            'admin.purchase.stock',
            'admin.item.index',
            'admin.supplier.index',
        ])
            ? 'show'
            : '' }}"
            id="purchase_management">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.supplier.index') }}"
                        class="nav-link {{ Request::routeIs('admin.supplier.index') ? 'active' : '' }}"
                        data-key="t-suppliers">Suppliers</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.item.index') }}"
                        class="nav-link {{ Request::routeIs('admin.item.index') ? 'active' : '' }}"
                        data-key="t-items">Items</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.purchase.index') }}"
                        class="nav-link {{ Request::routeIs('admin.purchase.index') ? 'active' : '' }}"
                        data-key="t-new-purchase">New Purchase</a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('admin.purchase.list') }}"
                        class="nav-link {{ Request::routeIs(['admin.purchase.list', 'admin.purchase.index', 'admin.purchase.view']) ? 'active' : '' }}"
                        data-key="t-purch-list">Purchase List</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.purchase.report') }}"
                        class="nav-link {{ Request::routeIs('admin.purchase.report') ? 'active' : '' }}"
                        data-key="t-starter">Purchase Report</a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('admin.purchase.stock') }}"
                        class="nav-link {{ Request::routeIs('admin.purchase.stock') ? 'active' : '' }}"
                        data-key="t-report">Stock Report</a>
                </li>

            </ul>
        </div>
    </li>
@endcan



@can('read summarized report')
    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Mail Income Report</span></li>

    <li class="nav-item">
        <a class="nav-link menu-link" href="#inboxingAdmin" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="inboxingAdmin">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Inboxing Incomes </span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.reporting.inboxing_ems',
            'admin.reporting.inboxing_ordinary',
            'admin.reporting.inboxing_registered',
            'admin.reporting.inboxing_percel',
        ])
            ? 'show'
            : '' }}"
            id="inboxingAdmin">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.reporting.inboxing_ordinary') }}"
                        class="nav-link {{ Request::routeIs('admin.reporting.inboxing_ordinary') ? 'active' : '' }}"
                        data-key="t-starter">Ordinary Mails</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reporting.inboxing_registered') }}"
                        class="nav-link {{ Request::routeIs('admin.reporting.inboxing_registered') ? 'active' : '' }}"
                        data-key="t-starter">Registered Mails</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reporting.inboxing_percel') }}"
                        class="nav-link {{ Request::routeIs('admin.reporting.inboxing_percel') ? 'active' : '' }}"
                        data-key="t-starter">Parcel Mails</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reporting.inboxing_ems') }}"
                        class="nav-link {{ Request::routeIs('admin.reporting.inboxing_ems') ? 'active' : '' }}"
                        data-key="t-starter">EMS</a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link menu-link" href="#outboxinMails" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="outboxinMails">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Outboxing Incomes </span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.reporting.outboxing_ems',
            'admin.reporting.outboxing_registered',
            'admin.reporting.outboxing_percel',
            'admin.reporting.outboxing_stamps',
        ])
            ? 'show'
            : '' }}"
            id="outboxinMails">
            <ul class="nav nav-sm flex-column">

                <li class="nav-item">
                    <a href="{{ route('admin.reporting.outboxing_registered') }}"
                        class="nav-link {{ Request::routeIs('admin.reporting.outboxing_registered') ? 'active' : '' }}"
                        data-key="t-starter">Registered Mails</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reporting.outboxing_percel') }}"
                        class="nav-link {{ Request::routeIs('admin.reporting.outboxing_percel') ? 'active' : '' }}"
                        data-key="t-starter">Parcel Mails</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reporting.outboxing_ems') }}"
                        class="nav-link {{ Request::routeIs('admin.reporting.outboxing_ems') ? 'active' : '' }}"
                        data-key="t-starter">EMS</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reporting.outboxing_stamps') }}"
                        class="nav-link {{ Request::routeIs('admin.reporting.outboxing_stamps') ? 'active' : '' }}"
                        data-key="t-starter">Stamps</a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link menu-link" href="#poboxingService" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="poboxingService">
            <i class="ri-pages-line"></i> <span data-key="t-pages">P.O.BOX Incomes </span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['admin.reporting.physical_pobox', 'admin.reporting.virtual_pobox'])
            ? 'show'
            : '' }}"
            id="poboxingService">
            <ul class="nav nav-sm flex-column">

                <li class="nav-item">
                    <a href="{{ route('admin.reporting.physical_pobox') }}"
                        class="nav-link {{ Request::routeIs('admin.reporting.physical_pobox') ? 'active' : '' }}"
                        data-key="t-starter">Physical P.O.Box</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reporting.virtual_pobox') }}"
                        class="nav-link {{ Request::routeIs('admin.reporting.virtual_pobox') ? 'active' : '' }}"
                        data-key="t-starter">Virtual P.O.Box</a>
                </li>

            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('admin.reporting.other_revenue') ? 'active' : '' }}"
            href="{{ route('admin.reporting.other_revenue') }}">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Other Revenues </span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('admin.reporting.home_delivery') ? 'active' : '' }}"
            href="{{ route('admin.reporting.home_delivery') }}">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Home Delivery </span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link menu-link" href="#mailincomereport" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="mailincomereport">
            <i class="ri-pages-line"></i> <span data-key="t-pages">Inboxing Incomes </span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.reporting.ems',
            'admin.reporting.registered',
            'admin.reporting.percel',
            'admin.reporting.percel',
            'admin.reporting.percel',
        ])
            ? 'show'
            : '' }}"
            id="mailincomereport">
            <ul class="nav nav-sm flex-column">
                @can('read summarized report')
                    <li class="nav-item">
                        <a href="{{ route('admin.reporting.ems') }}"
                            class="nav-link {{ Request::routeIs('admin.reporting.ems') ? 'active' : '' }}"
                            data-key="t-starter">EMS Mail income Report</a>
                    </li>
                @endcan
                @can('read summarized report')
                    <li class="nav-item">
                        <a href="{{ route('admin.reporting.registered') }}"
                            class="nav-link {{ Request::routeIs('admin.reporting.registered') ? 'active' : '' }}"
                            data-key="t-starter">Registered Small Packet Income Report</a>
                    </li>
                @endcan
                @can('read summarized report')
                    <li class="nav-item">
                        <a href="{{ route('admin.reporting.percel') }}"
                            class="nav-link {{ Request::routeIs('admin.reporting.percel') ? 'active' : '' }}"
                            data-key="t-starter">Percel Outboxing Income Report</a>
                    </li>
                @endcan
                @can('read summarized report')
                    <li class="nav-item">
                        <a href="{{ route('admin.reporting.temble') }}"
                            class="nav-link {{ Request::routeIs('admin.reporting.temble') ? 'active' : '' }}"
                            data-key="t-starter">Posting With Temble Income Report</a>
                    </li>
                @endcan
                @can('read summarized report')
                    <li class="nav-item">
                        <a href="{{ route('admin.reporting.postel') }}"
                            class="nav-link {{ Request::routeIs('admin.reporting.postel') ? 'active' : '' }}"
                            data-key="t-starter">Carte Postel Selling Report</a>
                    </li>
                @endcan

            </ul>
        </div>
    </li> --}}
@endcan


@can('read summarized report')
    <li class="nav-item">
        <a class="nav-link menu-link" href="#Summarized_Reports" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="Summarized_Reports">
            <i class="ri-equalizer-fill"></i> <span data-key="t-pages">Activity Agencies</span>
        </a>
        <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), [
            'admin.reporting.daily',
            'admin.reporting.daily_details',
            'admin.reporting.monthly',
            'admin.reporting.monthly_details',
            'admin.reporting.daily_expense',
            'admin.reporting.daily_expense_details',
            'admin.reporting.monthly_expense',
            'admin.reporting.monthly_expense_details',
            'admin.reporting.profit',
            'admin.reporting.index',
            'admin.reporting.expenses',
        ])
            ? 'show'
            : '' }}"
            id="Summarized_Reports">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.reporting.daily') }}"
                        class="nav-link {{ Request::routeIs(['admin.reporting.daily', 'admin.reporting.daily_details']) ? 'active' : '' }}"
                        data-key="t-starter">Daily Income Agencies Report</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.reporting.monthly') }}"
                        class="nav-link {{ Request::routeIs(['admin.reporting.monthly', 'admin.reporting.monthly_details']) ? 'active' : '' }}"
                        data-key="t-starter">Monthly Income Agencies Report</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reporting.daily_expense') }}"
                        class="nav-link {{ Request::routeIs(['admin.reporting.daily_expense', 'admin.reporting.daily_expense_details']) ? 'active' : '' }}"
                        data-key="t-starter">Daily Expense Agencies Report</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.reporting.monthly_expense') }}"
                        class="nav-link {{ Request::routeIs(['admin.reporting.monthly_expense', 'admin.reporting.monthly_expense_details']) ? 'active' : '' }}"
                        data-key="t-starter">Monthly Expense Agencies Report</a>
                </li>
                {{-- @can('read summarized report')
                    <li class="nav-item">
                        <a href="{{ route('admin.reporting.profit') }}"
                            class="nav-link {{ Request::routeIs('admin.reporting.profit') ? 'active' : '' }}"
                            data-key="t-starter">Monthly General (Income-Expense) Agencies Report</a>
                    </li>
                @endcan
                @can('read summarized report')
                    <li class="nav-item">
                        <a href="{{ route('admin.reporting.index') }}"
                            class="nav-link {{ Request::routeIs('admin.reporting.index') ? 'active' : '' }}"
                            data-key="t-starter">Activities Agencies Report</a>
                    </li>
                @endcan
                @can('read summarized report')
                    <li class="nav-item">
                        <a href="{{ route('admin.reporting.expenses') }}"
                            class="nav-link {{ Request::routeIs('admin.reporting.expenses') ? 'active' : '' }}"
                            data-key="t-starter">Expenses Agencies Report</a>
                    </li>
                @endcan --}}


            </ul>
        </div>
    </li>
@endcan
