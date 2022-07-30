import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { CommentService } from 'src/app/services/comment.service';
import { RivistaService } from 'src/app/services/rivista.service';

@Component({
  selector: 'app-rivista',
  templateUrl: './rivista.component.html',
  styleUrls: ['./rivista.component.scss'],
})
export class RivistaComponent implements OnInit {
  rivista: any = null;
  owner: boolean = false;
  user_id = null;

  constructor(
    private commentService: CommentService,
    private rivistaService: RivistaService,
    private router: Router,
    private route: ActivatedRoute,
    private auth: AuthService
  ) {}

  ngOnInit(): void {
    let slug = this.route.snapshot.paramMap.get('slug');

    if (slug) {
      this.rivistaService.get(slug).subscribe((response: any) => {
        this.rivista = response.data;
        this.owner = this.auth.getUser().id == this.rivista.user_id;
        this.user_id = this.auth.getUser().id;
        console.log(this.rivista);
      });
    } else {
      this.router.navigateByUrl('/');
    }
  }

  newComment(comment: any) {
    this.rivista.comments.push(comment);
  }

  deleteRivista() {
    this.rivistaService.delete(this.rivista.id).subscribe(() => {
      this.router.navigateByUrl('/');
    });
  }

  deleteComment(comment_id: number) {
    this.commentService.delete(comment_id).subscribe(() => {
      this.rivista.comments = this.rivista.comments.filter(
        (cmt: any) => cmt.id != comment_id
      );
    });
  }
}
