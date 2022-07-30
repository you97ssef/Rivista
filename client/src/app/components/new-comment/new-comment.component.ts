import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';
import { CommentService } from 'src/app/services/comment.service';

@Component({
  selector: 'app-new-comment',
  templateUrl: './new-comment.component.html',
  styleUrls: ['./new-comment.component.scss'],
})
export class NewCommentComponent implements OnInit {
  @Output() commentPosted = new EventEmitter<any>();
  @Input() rivista_id: any;
  comment: any;
  connected = false;

  constructor(
    private commentService: CommentService,
    private authService: AuthService
  ) {
    this.initComment();
  }

  ngOnInit(): void {
    this.comment.rivista_id = this.rivista_id;
    this.connected = this.authService.isAuthenticated();
  }

  initComment() {
    this.comment = {
      name: '',
      email: '',
      text: '',
    };
  }

  submit() {
    if (this.connected) {
      this.commentService
        .newFromConnected(this.comment)
        .subscribe((response: any) => {
          this.commentPosted.emit(response.data);
          this.initComment();
        });
    } else {
      this.commentService
        .newFromGuest(this.comment)
        .subscribe((response: any) => {
          this.commentPosted.emit(response.data);
          this.initComment();
        });
    }
  }
}
