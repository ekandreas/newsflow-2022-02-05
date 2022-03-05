@servers(['prod' => ['forge@13.53.44.234'],'localhost' => ['127.0.0.1']])

@task('pull', ['on' => 'localhost'])
    ssh -C forge@13.53.44.234 pg_dump --clean -U newsflow newsflow > dump.sql
    psql -d newsflow -U postgres < dump.sql
    rm dump.sql
@endtask
