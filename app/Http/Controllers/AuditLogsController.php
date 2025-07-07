<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\AuditLog;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class AuditLogsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($request->all() , $request->user_id);
        $query = AuditLog::with('user')->latest('audit_logs.created_at');
        $query->when($request->description ,function($x) use($request) {
            return $x->where('description' , $request->description);
        });
        $query->when($request->user_id , function($x) use($request){
            return $x->where('user_id' , $request->user_id);
        });
        $query->when($request->subject_id , function($x) use($request){
            return $x->where('subject_id' , $request->subject_id);
        });
        $query->when($request->subject_type , function($x) use($request){
            return $x->where('subject_type', 'like', '%'.$request->subject_type.'%');
        });


        $items = $query->paginate(100)->appends([
            'user_id' => request()->user_id,
            'subject_id' => request()->subject_id,
            'subject_type' => request()->subject_type,
            'description' => request()->description
        ]);
        $pageTitle = [
            'title' => __('Activity Logs'),
            'bread_crumbs' => [
                [
                    'title' => __('Home'),
                    'link'  => route('Admin.home')
                ],
            ]
        ];
        return view('Admin.auditLogs.index', compact('pageTitle', 'items'));
    }

    public function show(AuditLog $auditLog)
    {
        abort_if(Gate::denies('audit_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $local_title = $auditLog->id;
        $breadcrumbs[] = ['label' => __('Home'), 'url' => route('dashboard.home')];
        $breadcrumbs[] = ['label' => __('Activity Logs'), 'url' => route('dashboard.audit-logs.index')];
        $breadcrumbs[] = ['label' => $local_title];

        return view($this->template . '.auditLogs.show', compact('auditLog', 'local_title', 'breadcrumbs'));
    }
}
