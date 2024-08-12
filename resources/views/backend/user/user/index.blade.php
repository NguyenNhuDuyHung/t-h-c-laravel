@include('backend.dashboard.components.breadcrum', ['title' => $config['seo']['index']['title']])
<div class="row mt-20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $config['seo']['index']['tableHeading'] }}</h5>
                @include('backend.user.user.components.toolbox')
            </div>
            <div class="ibox-content">
                @include('backend.user.user.components.filter')
                @include('backend.user.user.components.table')
            </div>
        </div>
    </div>
</div>
