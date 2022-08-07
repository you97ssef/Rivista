import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor,
} from '@angular/common/http';
import { catchError, Observable, throwError } from 'rxjs';
import { ToastrService } from 'ngx-toastr';
import { Router } from '@angular/router';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor {
  constructor(private toastr: ToastrService, private router: Router) {}

  intercept(
    request: HttpRequest<unknown>,
    next: HttpHandler
  ): Observable<HttpEvent<unknown>> {
    return next.handle(request).pipe(
      catchError((response) => {
        switch (response.status) {
          case 422:
            let messages = '<ul>';
            for (let key in response.error.errors) {
              messages += '<li>' + response.error.errors[key] + '</li>';
            }
            messages += '</ul>';
            this.toastr.error(messages, response.error.message, {
              enableHtml: true,
            });
            break;

          case 401:
            this.toastr.error(response.error.message);
            if (response.error.message === 'Unauthenticated.') {
              localStorage.clear();
              this.router.navigate(['/login']);
            }
            break;

          case 404:
            this.router.navigateByUrl('/404');
            break;

          default:
            this.toastr.error(response.error.message);
            break;
        }

        return throwError(() => Error(response));
      })
    );
  }
}
